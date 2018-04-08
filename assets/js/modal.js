var modal = document.createElement("div");
                modal.setAttribute("id", "myModal");
                modal.setAttribute("class", "modal");
                modal.innerHTML = "";

                var modalContent = document.createElement("div");
                modalContent.setAttribute("class", "modal-content");

                var modalHeader = document.createElement("div");
                modalHeader.setAttribute("class", "modal-header");

                var span = document.createElement("span");
                span.setAttribute("class", "close");
                span.innerHTML = "&times;";
                
                var h2 = document.createElement("h2");
                h2.innerHTML = "Success!";
                
                var modalBody = document.createElement("div");
                modalBody.setAttribute("class", "modal-body");

                var modalText = document.createElement("p");
                modalText.setAttribute("id", "buy");
                modalText.innerHTML = "You add " + name + " in your bucket!";

                var modalFooter = document.createElement("div");
                modalFooter.setAttribute("class", "modal-footer");
                
                var h3 = document.createElement("h3");
                h3.innerHTML = "Nice book bro!";

                var btn = document.getElementById("buy");
                
                modalFooter.appendChild(h3);
                modalBody.appendChild(modalText);
                modalHeader.appendChild(span);
                modalHeader.appendChild(h2);
                modalContent.appendChild(modalHeader);
                modalContent.appendChild(modalBody);
                modalContent.appendChild(modalFooter);
                
                btn.onclick = function () {
                    modal.style.display = "block";
                };
                
                span.onclick = function () {
                    modal.style.display = "none";
                };
                
                window.onclick = function (event) {
                    if (event.target === modal) {
                        modal.style.display = "none";
                    }
                };
                var tab = document.getElementById("mod");
                tab.innerHTML = "";
                tab.appendChild(modalContent);


