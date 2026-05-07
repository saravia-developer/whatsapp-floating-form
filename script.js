if (document.getElementById("wff-wa-container")) {
  document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("wff-wa-container");
    const button = document.getElementById("wff-wa-button");
    const form = document.getElementById("wff-wa-form");
    const closeBtn = document.getElementById("wff-wa-close");
    const waForm = document.getElementById("wff-waForm");

    const phoneNumber = WFFData.phoneNumber || '';

    let expanded = false;

    button.addEventListener("click", () => {
      expanded = true;

      gsap.to(container, {
        width: 350,
        height: 520,
        borderRadius: 16,
        duration: 0.4,
      });

      form.style.display = "flex";

      gsap.fromTo(
        form,
        { opacity: 0, y: 20 },
        {
          opacity: 1,
          y: 0,
          duration: 0.3,
        },
      );
    });

    closeBtn.addEventListener("click", () => {
      expanded = false;

      gsap.to(form, {
        opacity: 0,
        y: 20,
        duration: 0.2,
        onComplete: () => (form.style.display = "none"),
      });

      gsap.to(container, {
        width: 70,
        height: 70,
        borderRadius: "50%",
        duration: 0.4,
      });
    });

    waForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const data = new FormData(waForm);

      const message = `
      *INFORMACIÓN DEL CLIENTE*
      Nombre: ${data.get("nombre")}
      Teléfono: ${data.get("codigoPais")} ${data.get("numero")}
      Correo: ${data.get("correo")}
      Página web: ${data.get("paginaWeb")}

      *DETALLES DEL PROYECTO*
      ${data.get("proyecto")}
    `;

      const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;

      window.open(url, "_blank");

      waForm.reset();
    });
  });
}
