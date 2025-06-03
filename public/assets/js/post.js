let editCaptionBtn;
let editCaptionForm;
let blurButton;

function commentHtml(comment) {
  return `
    <div data-comment-id="${comment.id}">
      <div class="row d-flex justify-content-center mb-2">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="d-flex flex-start align-items-center">
                  <img class="rounded-circle shadow-1-strong me-3"
                    src="/assets/images/profiles/${comment.user.id}.${comment.user.profile_photo_type}" 
                    onerror="this.src='/assets/images/user-default.png';" 
                    alt="avatar" width="40" height="40" /> 
                  <div>
                    <h6 class="fw-bold text-primary mb-1">${comment.user.fullname}</h6>
                    <p class="text-muted small mb-0">
                      ${comment.created_at}
                    </p>
                  </div>
                </div>
                  ${comment.can_delete || comment.can_edit
      ? `
                      <div class="dropdown text-end">
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bi bi-three-dots"></i>
                        </button>
                        <ul class="dropdown-menu">
                          ${comment.can_delete
        ? `
                                <li>
                                  <button class="dropdown-item text-danger delete-comment-btn" data-comment-id="${comment.id}">
                                    <i class="bi bi-trash3"></i> Eliminar
                                  </button>
                                </li>
                              `
        : ''
      }
                          ${comment.can_edit
        ? `
                                <li>
                                  <button class="dropdown-item edit-comment-btn" onclick='editComment(${comment.id}, ${JSON.stringify(comment)})'>
                                    <i class="bi bi-pencil-square"></i> Editar
                                  </button>
                                </li>
                              `
        : ''
      }
                        </ul>
                      </div>
                    `
      : ''
    }

              </div>
              <p class="mt-3 comment-text" data-comment-id="${comment.id}">${comment.comment}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  `;
}

function editComment(commentId, currentComment) {
  const commentCard = document.querySelector(`[data-comment-id="${commentId}"] .card-body`);

  // Crear un formulario de edición
  const editFormHtml = `
    <form class="edit-comment-form" onsubmit="submitEditComment(event, ${commentId})">
      <textarea class="form-control mb-2" rows="2">${currentComment.comment}</textarea>
      <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
      <button type="button" class="btn btn-secondary btn-sm" onclick='cancelEditComment(${commentId}, ${JSON.stringify(currentComment)})'>Cancelar</button>
    </form>
  `;

  // Reemplazar el contenido del comentario con el formulario
  commentCard.innerHTML = editFormHtml;
}

function submitEditComment(event, commentId) {
  event.preventDefault();

  const form = event.target;
  const newComment = form.querySelector('textarea').value.trim();

  if (!newComment) {
    alert('El comentario no puede estar vacío.');
    return;
  }

  fetch(`/comment/${commentId}/update`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ comment: newComment }),
  })
    .then(response => response.json())
    .then(data => {
      console.log('Respuesta del backend:', data);
      if (data.success) {
        // Restaurar el contenido original del comentario
        const commentElement = document.querySelector(`[data-comment-id="${commentId}"] `);
        commentElement.innerHTML = commentHtml(data.comment); // Reutilizar commentHtml para actualizar el comentario
      } else {
        alert('Error al actualizar el comentario.');
      }
    })
    .catch(error => {
      console.error('Error al actualizar el comentario:', error);
      alert('Error al actualizar el comentario.');
    });
}

function cancelEditComment(commentId, commentData) {
  const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);

  // Restaurar el contenido original del comentario usando commentHtml
  commentElement.innerHTML = commentHtml(commentData);
}



function deletePost(postId) {
  const postElement = document.querySelector(`[card-post-id="${postId}"]`);

  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡Esta acción eliminará el post permanentemente!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {
      fetch(`/post/${postId}/delete`, {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
        },
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            postElement.remove();
            Swal.fire(
              "¡Eliminado!",
              "El post ha sido eliminado correctamente.",
              "success"
            );
          } else {
            Swal.fire(
              "Error",
              "Error al eliminar el post.",
              "error"
            );
          }
        })
        .catch((error) => {
          console.error("Error al eliminar el post:", error);
          Swal.fire(
            "Error",
            "Error al eliminar el post.",
            "error"
          );
        });
    }
  });
}

function toggleBlur(postId, isBlurred) {
  const newBlurState = !isBlurred;

  fetch(`/post/${postId}/toggle-blur`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ is_blurred: newBlurState }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Actualizar el estado del blur en la card del post
        const postElement = document.querySelector(
          `[card-post-id="${postId}"]`
        );
        const mediaElement = postElement.querySelector(
          ".post-image, .post-video"
        );
        const blurButton = postElement.querySelector(".toggle-blur-btn");
        const modalTriggerButton = document.querySelector(
          `[data-post-id="${postId}"][data-bs-toggle="modal"]`
        );

        if (data.is_blurred) {
          mediaElement.classList.add("blurred");
          blurButton.innerHTML = '<i class="bi bi-file-lock-fill"></i> Enfocar';
          blurButton.setAttribute("onclick", `toggleBlur(${postId}, true)`);
          modalTriggerButton.setAttribute("data-is-blurred", "true"); // Actualizar el estado del blur en el botón del modal
        } else {
          mediaElement.classList.remove("blurred");
          blurButton.innerHTML = '<i class="bi bi-file-lock"></i> Desenfocar';
          blurButton.setAttribute("onclick", `toggleBlur(${postId}, false)`);
          modalTriggerButton.setAttribute("data-is-blurred", "false"); // Actualizar el estado del blur en el botón del modal
        }

      } else {
        alert("Error al actualizar el estado del blur.");
      }
    })
    .catch((error) => {
      console.error("Error al actualizar el estado del blur:", error);
      alert("Error al actualizar el estado del blur.");
    });
}

function showEditCaptionForm() {
  editCaptionBtn.classList.add("d-none");
  editCaptionForm.classList.remove("d-none");
}

document.addEventListener("DOMContentLoaded", function () {
  const commentsModal = document.getElementById("commentsModal");
  const modalBody = commentsModal.querySelector(".comments");

  editCaptionBtn = document.getElementById("edit-caption-btn");
  editCaptionForm = document.getElementById("edit-caption-form");
  const newCaptionInput = document.getElementById("new-caption");
  const cancelEditCaptionBtn = document.getElementById("cancel-edit-caption");
  const modalPostCaption = commentsModal.querySelector(".modal-post-caption");

  const addCommentForm = commentsModal.querySelector("#add-comment-form");
  const commentTextarea = addCommentForm.querySelector("#comment-textarea");
  const deleteCommentBtn = commentsModal.querySelector(".delete-comment-btn");
  blurButton = document.getElementById("blur-btn");

  commentsModal.addEventListener("show.bs.modal", function (event) {
    const button = event.relatedTarget; // Botón que activó el modal
    const postId = button.getAttribute("data-post-id"); // Obtener el ID del post
    commentsModal.setAttribute("data-post-id", postId);
    const isBlurred = button.getAttribute("data-is-blurred") === "true"; // Verificar si el post está bloqueado

    const postCaption = button.getAttribute("data-post-caption"); // Obtener la caption del post

    const postUsername = button.getAttribute("data-post-username"); // Obtener el username del post
    const postUserId = button.getAttribute("data-post-userId"); // Obtener el username del post
    const postRoute = button.getAttribute("data-post-route"); // Obtener la ruta del post
    const postType = button.getAttribute("data-post-type"); // Obtener el tipo del post

    const modalMedia = commentsModal.querySelector(".modal-media"); // Obtener la media del contenedor modal-media
    const modalPostUsername = commentsModal.querySelector(
      ".modal-post-username"
    ); // Obtener el contenedor del username del modal

    // const modalPostImage = commentsModal.querySelector('.modal-post-image');

    modalPostUsername.innerHTML = `<a href="/@${postUsername}" class="text-decoration-none text-body">${postUsername}</a>`;
    modalPostCaption.innerHTML = postCaption;
    // modalPostImage.setAttribute('src', postRoute);
    modalMedia.innerHTML = ""; // Limpiar el contenido previo

    if (editCaptionBtn) editCaptionBtn.setAttribute("data-post-id", postId); // Establecer la caption del post en el botón de editar caption

    // Renderizar dinámicamente imagen o video
    if (postType === "mp4") {
      // Renderizar video
      const video = document.createElement("video");
      video.setAttribute("controls", "");
      video.setAttribute("style", "width: 100%; object-fit: cover;");
      if (isBlurred) {
        video.classList.add("blurred"); // Aplicar la clase blurred si el post está bloqueado
      }
      const source = document.createElement("source");
      source.setAttribute("src", postRoute);
      source.setAttribute("type", "video/mp4");
      video.appendChild(source);
      modalMedia.appendChild(video);
    } else {
      // Renderizar imagen
      const img = document.createElement("img");
      img.setAttribute("src", postRoute);
      img.setAttribute("alt", "Post Media");
      img.setAttribute("style", "width: 100%; object-fit: cover;");
      if (isBlurred) {
        img.classList.add("blurred"); // Aplicar la clase blurred si el post está bloqueado
      }
      modalMedia.appendChild(img);
    }

    // Actualizar Mostrar el contenido del caption modal de comentarios
    // Campo editable del contenido del caption modal de comentarios
    modalPostCaption.textContent = postCaption;
    newCaptionInput.value = postCaption;

    // Mostrar el botón de editar caption y ocultar el formulario
    if (editCaptionBtn) editCaptionBtn.classList.remove("d-none");
    editCaptionForm.classList.add("d-none");

    // Limpiar el contenido del modal de caption
    modalBody.innerHTML = "<p>Cargando comentarios...</p>";

    // Hacer una solicitud AJAX para obtener los comentarios
    fetch(`/post/${postId}/comments`)
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Generar el HTML de los comentarios
          let commentsHtml = "";
          data.comments.forEach((comment) => {
            commentsHtml += commentHtml(comment);
          });
          modalBody.innerHTML = commentsHtml;
        } else {
          modalBody.innerHTML = "<p>" + data.message + "</p>";
        }
      })
      .catch((error) => {
        console.error("Error al cargar los comentarios:", error);
        modalBody.innerHTML = "<p>Error al cargar los comentarios.</p>";
      });
  });


  // Cancelar la edición
  cancelEditCaptionBtn.addEventListener("click", () => {
    editCaptionForm.classList.add("d-none");
    editCaptionBtn.classList.remove("d-none");
  });

  // Manejar el envío del formulario para actualizar el caption
  editCaptionForm.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log("Enviando nueva descripción...");

    const postId = editCaptionBtn.getAttribute("data-post-id");
    const newCaption = newCaptionInput.value;

    fetch(`/post/${postId}/update-caption`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        caption: newCaption,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          const postCaptionElement = document.querySelector(
            `[card-post-caption="${postId}"]`
          );
          modalPostCaption.textContent = newCaption;
          postCaptionElement.textContent = newCaption;
          editCaptionForm.classList.add("d-none");
          editCaptionBtn.classList.remove("d-none");
          alert("Descripción actualizada correctamente.");
        } else {
          alert("Error al actualizar la descripción.");
        }
      })
      .catch((error) => {
        console.error("Error al actualizar la descripción:", error);
        alert("Error al actualizar la descripción.");
      });
  });

  // Manejar el envío del formulario para agregar un comentario
  addCommentForm.addEventListener("submit", (e) => {
    e.preventDefault();
    console.log("Enviando comentario...");
    const postId = commentsModal.getAttribute("data-post-id"); // Obtener el ID del post desde el modal
    const comment = commentTextarea.value.trim();

    if (!comment) {
      alert("El comentario no puede estar vacío.");
      return;
    }

    // Enviar el comentario al backend
    fetch(`/post/${postId}/comments`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        comment: comment,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Respuesta del backend:", data);
        if (data.success) {
          if (!data.has_more_comments) {
            modalBody.innerHTML = ""; // Limpiar el contenido del modal
          }
          // Agregar el nuevo comentario al inicio de la lista
          const newCommentHtml = commentHtml(data.comment);
          modalBody.insertAdjacentHTML("afterbegin", newCommentHtml);
          commentTextarea.value = ""; // Limpiar el textarea
        } else {
          alert("Error al agregar el comentario 1.");
        }
      })
      .catch((error) => {
        console.error("Error al agregar el comentario2:", error);
        alert("Error al agregar el comentario2.");
      });
  });

  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("delete-comment-btn")) {
      const commentId = e.target.getAttribute("data-comment-id");
      const commentElement = document.querySelector(
        `[data-comment-id="${commentId}"]`
      );

      Swal.fire({
        title: "¿Estás seguro?",
        text: "Esta acción eliminará el comentario permanentemente.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
      }).then((result) => {
        if (result.isConfirmed) {
          //Enviar Solicitud al backend para eliminar el comentario
          fetch(`/comment/${commentId}/delete`, {
            method: "DELETE",
            headers: {
              "Content-Type": "application/json",
            },
          })
            .then((response) => response.json())
            .then((data) => {
              if (data.success) {
                //Eliminar el comentario del DOM
                commentElement.remove();
                Swal.fire(
                  "¡Eliminado!",
                  "El comentario ha sido eliminado correctamente.",
                  "success"
                );
              } else {
                Swal.fire(
                  "Error",
                  "Error al eliminar el comentario.",
                  "error"
                );
              }
            })
            .catch((error) => {
              console.error("Error al eliminar el comentario:", error);
              Swal.fire(
                "Error",
                "Error al eliminar el comentario.",
                "error"
              );
            });
        }
      });
    }
  });
});
