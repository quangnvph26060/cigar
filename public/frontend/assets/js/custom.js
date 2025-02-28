(function() {
    var n = document.querySelectorAll("body.bootstrap");
    if (n.length == 0) {
        var t = document.querySelectorAll(".js-modal-regional-settings");
        var m = document.querySelector("#modal_regional_settings");
        var r = "/binary/service/regional_settings_modal_content?ref=";
        t.forEach((el) => {
            el.addEventListener("click", function(e) {
                e.preventDefault();
                var ref = el.closest(".mhead") !== null ? "mhead" : "";
                ref =
                    ref == "" && el.closest(".dhead") !== null ? "dhead" : ref;
                $(m).modal({
                    remote: r.replace("ref=", "ref=" + ref),
                });
                return false;
            });
        });
    }
})();

// $(document).ready(function() {
//     paintAroma(NameArrObj);
//     createSchieber();
// });
$("img[data-src]:not(.swiper-lazy)").unveil(100, function() {
    $(this).on("load", function() {
        $(this).addClass("unveiled");
    });
});

(function() {
    var mmenu = document.querySelector("#mmenu");
    if (mmenu === null) {
        return;
    }

    var selectedElement = document.querySelector(
        '#mmenu li a[href="' +
        window.location.href
        .toString()
        .substring(window.location.origin.length) +
        '"]'
    );

    if (selectedElement === null) {
        var pathnameArr = window.location.pathname.split("/");

        for (i = 0; i < pathnameArr.length - 1; i++) {
            var tmp = (i > 0 ? pathnameArr.slice(0, -i) : pathnameArr).join(
                "/"
            );
            var elements = document.querySelectorAll(
                '#mmenu li a[href^="' + tmp + '"]'
            );
            if (elements.length > 0) {
                selectedElement = elements[0];
                break;
            }
        }
    }

    if (selectedElement === null) {
        selectedElement = document.querySelector("#mmenu li a[href]");
    }

    if (selectedElement !== null) {
        selectedElement.classList.add("mmenu-selected");
    }

    window.addEventListener("load", function(e) {
        var menu = new MmenuLight(mmenu, "all");

        var navigator = menu.navigation({
            selectedClass: "mmenu-selected",
            //slidingSubmenus: true,
            //theme: 'dark',
            title: "Menü",
        });

        var drawer = menu.offcanvas({
            //position: 'left'
        });

        document
            .querySelector('a[href="#mmenu"]')
            .addEventListener("click", (event) => {
                event.preventDefault();
                drawer.open();
            });

        mmenu.classList.remove("d-none");
    });
})();
