require(['jquery', 'jquery/ui'], function ($) {
    var $m = $.noConflict();
    $m(document).ready(function () {

        $m("#lk_check1").change(function () {
            if ($("#lk_check2").is(":checked") && $("#lk_check1").is(":checked")) {
                $("#activate_plugin").removeAttr('disabled');
            }
        });

        $m("#lk_check2").change(function () {
            if ($("#lk_check2").is(":checked") && $("#lk_check1").is(":checked")) {
                $("#activate_plugin").removeAttr('disabled');
            }
        });

        $m(".navbar a").click(function () {
            $id = $m(this).parent().attr('id');
            setactive($id);
            $href = $m(this).data('method');
            voiddisplay($href);
        });
        $m(".btn-link").click(function () {
            $m(this).siblings('.show_info').slideToggle('slow');

        });
        $m('#idpguide').on('change', function () {
            var selectedIdp = jQuery(this).find('option:selected').val();
            $m('#idpsetuplink').css('display', 'inline');
            $m('#idpsetuplink').attr('href', selectedIdp);
        });
        $m("#mo_saml_add_shortcode").change(function () {
            $m("#mo_saml_add_shortcode_steps").slideToggle("slow");
        });
        $m('#error-cancel').click(function () {
            $error = "";
            $m(".error-msg").css("display", "none");
        });
        $m('#success-cancel').click(function () {
            $success = "";
            $m(".success-msg").css("display", "none");
        });
        $m('#cURL').click(function () {
            $m(".help_trouble").click();
            $m("#cURLfaq").click();
        });
        $m('#help_working_title1').click(function () {
            $m("#help_working_desc1").slideToggle("fast");
        });
        $m('#help_working_title2').click(function () {
            $m("#help_working_desc2").slideToggle("fast");
        });

    });
});

function setactive($id) {
    $m(".navbar-tabs>li").removeClass("active");
    $id = '#' + $id;
    $m($id).addClass("active");
}

function voiddisplay($href) {
    $m(".page").css("display", "none");
    $m($href).css("display", "block");
}

function mosp_valid(f) {
    !(/^[a-zA-Z?,.\(\)\/@ 0-9]*$/).test(f.value) ? f.value = f.value.replace(/[^a-zA-Z?,.\(\)\/@ 0-9]/, '') : null;
}

function ifUserRegistered() {
    if (document.getElementById('registered').checked) {
        jQuery('#confirmPassword').css('display', 'none');
        jQuery('#firstName').css('display', 'none');
        jQuery('#lastName').css('display', 'none');
        jQuery('#company').css('display', 'none');
    } else {
        jQuery('#confirmPassword').css('display', 'block');
        jQuery('#firstName').css('display', 'block');
        jQuery('#lastName').css('display', 'block');
        jQuery('#company').css('display', 'block');
    }

}

function supportAction() {
}

function showLKDiv() {
    var y = document.getElementById("hide_show_lk_div");
    if (y.style.display == "none") {

        y.style.display = "block";
    } else {

        y.style.display = "none";
    }
}

function showInfoDiv() {
    var y = document.getElementById("hide_show_info_div");
    if (y.style.display == "none") {

        y.style.display = "block";
    } else {

        y.style.display = "none";
    }
}

function toggleIpInput() {
    var ipInputContainer = document.getElementById('ipInputContainer');
    var enableIpWhitelisting = document.getElementById('enableIpWhitelisting');

    if (enableIpWhitelisting.checked) {
        ipInputContainer.style.display = 'block';
    } else {
        ipInputContainer.style.display = 'none';
    }
}

function toggleIpInputAdmin() {

    var ipInputContainer = document.getElementById('ipInputContainerAdmin');
    var enableIpWhitelisting = document.getElementById('enableIpWhitelistingAdmin');

    if (enableIpWhitelisting.checked) {
        ipInputContainer.style.display = 'block';
    } else {
        ipInputContainer.style.display = 'none';
    }

}

function openAllProducts() {
    window.open("https://plugins.miniorange.com/magento", "_blank");
}