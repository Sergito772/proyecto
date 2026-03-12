var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");

    const panel = this.nextElementSibling; 
    if (panel.style.display === "block") { 
      panel.style.display = "none"; 
    } else {
      panel.style.display = "block"; 
    }

    /*const paneles = document.getElementsByClassName("panel")

    Array.from(paneles).forEach(panel => {
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style = `display: block;
                padding: 12px 18px;
                align-items: center;
                margin-bottom: 8px;
                font-weight: 500;
                cursor: pointer;`
        }
    });*/
  });
}