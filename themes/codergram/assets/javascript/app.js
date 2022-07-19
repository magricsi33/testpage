let progress = false;

openMobileMenu = (e) => {
    e.preventDefault();
    $(".mobile-menu").toggleClass("active");
    $(".mobile-menu-wrapper").toggleClass("active");
}

openCategory = (event) => {
    event.preventDefault();

    $(".category-wrapper").find(".subcategories").slideUp();
    $(event.target).parent().parent().find(".subcategories").slideDown();
}

onCloseMobileMenu = () => {
    $(".mobile-menu").removeClass("active");
    $(".mobile-menu-wrapper").removeClass("active");
}

$(document).ready(function() {

    $("#products-menu").hover(function() {
        $(this).find(".custom-dropdown-menu").stop().toggle();
    });

    $(".custom-dropdown-menu .category").hover(function() {
        $(this).find(".submenu").stop().toggle();
    });

    $(".tt").tooltip();

    $(".navbar .cart-menu").hover(function() {
        if(!progress) {
        progress = true;
            $(this).find('.card').slideToggle(700, function() {
                progress = false;
            });
        }
    });

    $(".infos .info").click(function() {
        let icon = $(this).find("svg");

        $(this).closest(".accordion").find("svg").removeClass("fa-minus").addClass("fa-plus");

        icon.addClass("fa-minus");
    });
});

function checkCoupon(data) {
    if (data.responseJSON.error) {
        $.oc.flashMsg({
            interval: 3,
            text: data.responseJSON.error,
            class: 'error'
        });
    }
    return;
}

function sendCouponForm(event) {
    let key = event.keyCode;

    if(key === 13 || key === undefined) {
        let code = $("#coupon_code").val();

        $(this).request("onAddCoupon", {
            data: {
                code: code
            },
            complete: (data) => {
                checkCoupon(data);
            }
        });
    }
}