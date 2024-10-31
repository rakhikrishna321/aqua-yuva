/*  ---------------------------------------------------
    Template Name: Ogani
    Description:  Ogani eCommerce  HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

"use strict";

(function($) {
    /*------------------
          Preloader
      --------------------*/
    $(window).on("load", function() {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
                Gallery filter
            --------------------*/
        $(".featured__controls li").on("click", function() {
            $(".featured__controls li").removeClass("active");
            $(this).addClass("active");
        });
        if ($(".featured__filter").length > 0) {
            var containerEl = document.querySelector(".featured__filter");
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
          Background Set
      --------------------*/
    $(".set-bg").each(function() {
        var bg = $(this).data("setbg");
        $(this).css("background-image", "url(" + bg + ")");
    });

    //Humberger Menu
    $(".humberger__open").on("click", function() {
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on("click", function() {
        $(".humberger__menu__wrapper").removeClass(
            "show__humberger__menu__wrapper"
        );
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: "#mobile-menu-wrap",
        allowParentLinks: true,
    });

    /*-----------------------
          Categories Slider
      ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: [
            "<span class='fa fa-angle-left'><span/>",
            "<span class='fa fa-angle-right'><span/>",
        ],
        animateOut: "fadeOut",
        animateIn: "fadeIn",
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            },
        },
    });

    $(".hero__categories__all").on("click", function() {
        $(".hero__categories ul").slideToggle(400);
    });

    /*--------------------------
          Latest Product Slider
      ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: [
            "<span class='fa fa-angle-left'><span/>",
            "<span class='fa fa-angle-right'><span/>",
        ],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*-----------------------------
          Product Discount Slider
      -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            },
        },
    });

    /*---------------------------------
          Product Details Pic Slider
      ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data("min"),
        maxPrice = rangeSlider.data("max");
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function(event, ui) {
            minamount.val("$" + ui.values[0]);
            maxamount.val("$" + ui.values[1]);
        },
    });
    minamount.val("$" + rangeSlider.slider("values", 0));
    maxamount.val("$" + rangeSlider.slider("values", 1));

    /*--------------------------
          Select
      ----------------------------*/
    $("select").niceSelect();

    /*------------------
		Single Product
	--------------------*/
    $(".product__details__pic__slider img").on("click", function() {
        var imgurl = $(this).data("imgbigurl");
        var bigImg = $(".product__details__pic__item--large").attr("src");
        if (imgurl != bigImg) {
            $(".product__details__pic__item--large").attr({
                src: imgurl,
            });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $(".pro-qty");
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on("click", ".qtybtn", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.hasClass("inc")) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });
})(jQuery);

function showpwd(id) {
    var x = document.getElementById(id);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
$(document).on("click", ".dynamicPopup", function(e) {
    e.preventDefault();
    let url = $(this).data("url");
    // console.log(url);
    let pop = $(this).data("pop");
    $(".popupContent-" + pop).html(
        '<center><p class="my-5">please wait</p></center>'
    );
    $.ajax({
            url: url,
            type: "GET",
            dataType: "html",
        })
        .done(function(data) {
            $(".popupContent-" + pop).html(
                '<center><p class="my-5 nf">Please wait...</p></center>'
            );
            $(".popupContent-" + pop).html(data);
        })
        .fail(function() {
            $(".popupContent-" + pop).html(
                '<div class="modal-body text-center pt-5 pb-5"><h4 class="text-muted text-center mb-5 nf">uh-oh! Something went wrong!</h4><button type="button" class="s-btn btn bg-danger px-4 text-uppercase text-white rounded-10 mr-2 modalClose" data-dismiss="modal">Close</button><button type="button" onclick="location.reload(true);" class="s-btn btn btn-primary px-4 rounded-10 text-uppercase text-white">RELOAD</button></div>'
            );
        });
});

function hidemsgs() {
    $("#success_msg").hide();
    $("#err_msg").hide();
}

function success_msg(msg, time) {
    $("#success_msg").text(msg);
    $("#success_msg").show();
    $("#err_msg").hide();
    if (time > 0) {
        setTimeout(function() {
            $("#success_msg").hide();
        }, time * 1000);
    }
}

function err_msg(msg, time) {
    $("#err_msg").text(msg);
    $("#err_msg").show();
    $("#success_msg").hide();
    if (time > 0) {
        setTimeout(function() {
            $("#err_msg").hide();
        }, time * 1000);
    }
}

function addtocart(product) {
    $.ajax({
        type: "POST",
        url: window.location.origin + '/actions/addtocart.php?product=' + product,
        data: '',
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            let result = JSON.parse(JSON.stringify(data));
            if (result.status == 1) {
                success_msg(result.message, 3);
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                err_msg(result.message, 3);
            }
        },
        error: function(data) {
            console.log("error");
            console.log(data);
        },
    });
}

function updatecart(product) {
    var qty = $("#" + product).val();
    $.ajax({
        type: "POST",
        url: window.location.origin + '/actions/updatecart.php?product=' + product + '&qty=' + qty,
        data: '',
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            let result = JSON.parse(JSON.stringify(data));
            if (result.status == 1) {
                success_msg(result.message, 3);
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                err_msg(result.message, 3);
            }
        },
        error: function(data) {
            console.log("error");
            console.log(data);
        },
    });
}

function deletecart(product) {
    $.ajax({
        type: "POST",
        url: window.location.origin + '/actions/deletecart.php?product=' + product,
        data: '',
        dataType: "JSON",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            let result = JSON.parse(JSON.stringify(data));
            if (result.status == 1) {
                success_msg(result.message, 3);
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                err_msg(result.message, 3);
            }
        },
        error: function(data) {
            console.log("error");
            console.log(data);
        },
    });
}