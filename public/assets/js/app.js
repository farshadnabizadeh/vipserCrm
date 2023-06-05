var reservationID;
var customerID;
var totalCost = [];
var servicePieces = [];
var total;
//source reports
var sourceNames = [];
var sourceColors = [];
var sourceCounts = [];
//vehicle reports
var vehicleNames = [];
var vehicleColors = [];
var vehicleCounts = [];

var HIDDEN_URL = {
    RESERVATION: '/definitions/reservations',
    SOURCES: '/definitions/sources',
    USER: '/definitions/users',
    HOME: '/home'
}

function dashboard() {
    try {
        setTimeout(() => {
            new Chart(document.getElementById("source-chart"), {
                type: 'bar',
                data: {
                    labels: sourceNames,
                    datasets: [{
                        label: "Rezervasyon Kaynak Özetleri",
                        backgroundColor: sourceColors,
                        data: sourceCounts
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: ''
                    }
                }
            });

            new Chart(document.getElementById("vehicles-chart"), {
                type: 'bar',
                data: {
                    labels: vehicleNames,
                    datasets: [{
                        label: "Araç Özetleri",
                        backgroundColor: vehicleColors,
                        data: vehicleCounts
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: ''
                    }
                }
            });
        }, 1000);
    }
    catch (error) {
        console.log(error);
    }
}

function voucherPdf() {
    try {
        var elem = document.getElementById('root');
        let date_ob = new Date();
        let date = ("0" + date_ob.getDate()).slice(-2);
        let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
        let year = date_ob.getFullYear();
        var now_date = (date + "." + month + "." + year);

        html2pdf().from(elem).set({
            margin: 0,
            filename: 'Care Plan-' + now_date + '.pdf',
            html2canvas: {
                scale: 2,
                y: -2
            },
            jsPDF: {
                orientation: 'portrait',
                unit: 'in',
                format: 'letter',
                compressPDF: true
            }
        }).save();
    }
    catch (error) {
        console.info(error);
    }
    finally {}
}

function paymentReportPdf() {
    try {
        var elem = document.getElementById('root');
        let date_ob = new Date();
        let date = ("0" + date_ob.getDate()).slice(-2);
        let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
        let year = date_ob.getFullYear();
        var now_date = (date + "." + month + "." + year);

        html2pdf().from(elem).set({
            margin: 0,
            filename: 'Ciro Raporu-' + now_date + '.pdf',
            html2canvas: {
                scale: 2,
                y: -2
            },
            jsPDF: {
                orientation: 'portrait',
                unit: 'in',
                format: 'letter',
                compressPDF: true
            }
        }).save();
    }
    catch (error) {
        console.info(error);
    }
    finally {}
}

function timeFormat(timeInput) {
    try {
        validTime = timeInput.value;
        if (validTime < 24 && validTime.length == 2) {
            timeInput.value = timeInput.value + ":";
            return false;
        }
        if (validTime == 24 && validTime.length == 2) {
            timeInput.value = timeInput.value.length - 2 + "0:";
            return false;
        }
        if (validTime > 24 && validTime.length == 2) {
            timeInput.value = "";
            return false;
        }
        if (validTime.length == 5 && validTime.slice(-2) < 60) {
            timeInput.value = timeInput.value + "";
            return false;
        }
        if (validTime.length == 5 && validTime.slice(-2) > 60) {
            timeInput.value = timeInput.value.slice(0, 2) + "";
            return false;
        }
        if (validTime.length == 5 && validTime.slice(-2) == 60) {
            timeInput.value = timeInput.value.slice(0, 2) + ":00";
            return false;
        }
    } catch (error) {
        console.info(error);
    } finally {
    }
}

var dataTable;
var select2Init = function() {
    $("#general").select2({ placeholder: "", dropdownAutoWidth: true, allowClear: true });
    $("#formStatusId").select2({ placeholder: "Form Durumunu Seçiniz", dropdownAutoWidth: true, allowClear: true });
    $("#country").select2({ placeholder: "Ülke Seç", dropdownAutoWidth: true, allowClear: true });
    $("#sobId").select2({ placeholder: "Rezervasyon Kaynağı", dropdownAutoWidth: true, allowClear: true });
    $("#paymentType").select2({ placeholder: "Ödeme Türü Seç", dropdownAutoWidth: true, allowClear: true });
    $("#vehicleId").select2({ placeholder: "Araç Seçiniz", dropdownAutoWidth: true, allowClear: true });
    $("#brandId").select2({ placeholder: "Marka Seçiniz", dropdownAutoWidth: true, allowClear: true });
    $("#selectedSource").select2({ placeholder: "Rezervasyon Kaynak Seç", dropdownAutoWidth: true, allowClear: true });
    $("#routeTypeID").select2({ placeholder: "Rota Türü Seçiniz", dropdownAutoWidth: true, allowClear: true });

};

var dataTableInit = function() {
    dataTable = $('#dataTable').dataTable({
        "columnDefs": [{
                "targets": 1,
                "type": 'num',
            },
            {
                "targets": 2,
                "type": 'num',
            }
        ],
    });
    tableSource = $('#tableSource').dataTable({
        "columnDefs": [{
                "targets": 1,
                "type": 'num',
            },
            {
                "targets": 2,
                "type": 'num',
            }
        ],
    });
};

var dtSearchInit = function() {
    $('#filterMedicalDepartment').on("change", function() {
        dtSearchAction($(this), 2)
    });
};

dtSearchAction = function(selector, columnId) {
    var fv = selector.val();
    if ((fv == '') || (fv == null)) {
        dataTable.api().column(columnId).search('', true, false).draw();
    } else {
        dataTable.api().column(columnId).search(fv, true, false).draw();
    }
};

var app = (function() {

    if ([HIDDEN_URL.HOME].includes(window.location.pathname)) {
        dashboard();
    }

    $(document).ready(function() {
        select2Init();
        dataTableInit();
        dtSearchInit();
    });

    $.ajax({
        url: '/reports/sourceReport',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            if (response) {
                $.each(response, function (key, value) {
                    sourceNames.push(value.name);
                    sourceColors.push(value.color);
                    sourceCounts.push(value.aCount);
                });
            }
        },

        error: function () {
        },
    });

    $.ajax({
        url: '/reports/vehicleReport',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            if (response) {
                $.each(response, function (key, value) {
                    vehicleNames.push(value.model + ' / ' + value.number_plate);
                    vehicleColors.push('#'+Math.floor(Math.random()*16777215).toString(16));
                    vehicleCounts.push(value.aCount);
                });
            }
        },

        error: function () { },
    });

    reservationStep();
    getCustomerId();
    getDiscountDetail();
    completeReservation();
    clockPicker();
    datePicker();
    addCustomertoReservationModal();
    //payment type
    addPaymentTypeOperation();
    createPaymentTypeOperation();
    //payment type end

    //booking forms
    bookingFormStatusBtn();
    //booking forms end

    //contact forms
    contactFormStatusBtn();
    //contact forms end

    addReservationOperation();
    addcustomerReservation();

    $("#colorpicker").spectrum();

    var pageurl = window.location.href;
        $(".nav-item_sub li a").each(function(){
            if ($(this).attr("href") == pageurl || $(this).attr("href") == '')
            $(this).addClass("active");
        });

        $(".nav-item_sub li a").each(function(){
            if ($(this).attr("href") == pageurl || $(this).attr("href") == '')
            $(this).parents(':eq(2)').addClass("active");
        });

    $.ajax({
        url: '/getCurrencies',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response) {
                $.each(response, function(key, value) {
                    $("#currenciesSection").append("<span class='currencyText'>" + value[0] + "</span>");
                });
            }
        },
        error: function() {
            console.log();
        },
    });

    $(document).ready(function(){

        $(".booking-status-btn").on("click", function(){
            var dataId = this.id;
            console.log(dataId);
            $("#booking_form_id").val(dataId);
        });

        $(".contact-status-btn").on("click", function () {
            var dataId = $(this).attr("data-id");
            $("#contact_form_id").val(dataId);
        });
    });

    $("#tableData").dataTable({ paging: true, pageLength: 25 });
    $("#tableGuides").dataTable({ paging: true, pageLength: 25 });
    $("#tableCountry").dataTable({ paging: true, pageLength: 25 });

    $('.navbar-nav li a').on('click', function () {
        $(this).parent().toggleClass('active');
    });
});

var Layout = (function() {

    function pinSidenav() {
        $('.sidenav-toggler').addClass('active');
        $('.sidenav-toggler').data('action', 'sidenav-unpin');
        $('body').removeClass('g-sidenav-hidden').addClass('g-sidenav-show g-sidenav-pinned');
        $('body').append('<div class="backdrop d-xl-none" data-action="sidenav-unpin" data-target=' + $('#sidenav-main').data('target') + ' />');
        Cookies.set('sidenav-state', 'pinned');
    }

    function unpinSidenav() {
        $('.sidenav-toggler').removeClass('active');
        $('.sidenav-toggler').data('action', 'sidenav-pin');
        $('body').removeClass('g-sidenav-pinned').addClass('g-sidenav-hidden');
        $('body').find('.backdrop').remove();
        Cookies.set('sidenav-state', 'unpinned');
    }

    var $sidenavState = Cookies.get('sidenav-state') ? Cookies.get('sidenav-state') : 'pinned';

    if ($(window).width() > 1200) {
        if ($sidenavState == 'pinned') {
            pinSidenav()
        }

        if (Cookies.get('sidenav-state') == 'unpinned') {
            unpinSidenav()
        }

        $(window).resize(function() {
            if ($('body').hasClass('g-sidenav-show') && !$('body').hasClass('g-sidenav-pinned')) {
                $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
            }
        });
    }

    if ($(window).width() < 1200) {
        $('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
        $('body').removeClass('g-sidenav-show');
        $(window).resize(function() {
            if ($('body').hasClass('g-sidenav-show') && !$('body').hasClass('g-sidenav-pinned')) {
                $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hidden');
            }
        });
    }

    $('.sidenav').on('mouseenter', function() {
        if (!$('body').hasClass('g-sidenav-pinned')) {
            $('body').removeClass('g-sidenav-hide').removeClass('g-sidenav-hidden').addClass('g-sidenav-show');
        }
    });

    $('.sidenav').on('mouseleave', function() {
        if (!$('body').hasClass('g-sidenav-pinned')) {
            $('body').removeClass('g-sidenav-show').addClass('g-sidenav-hide');

            setTimeout(function() {
                $('body').removeClass('g-sidenav-hide').addClass('g-sidenav-hidden');
            }, 300);
        }
    });

    $(window).on('load resize', function() {
        if ($('body').height() < 800) {
            $('body').css('min-height', '100vh');
            $('#footer-main').addClass('footer-auto-bottom')
        }
    });
})();

var CopyIcon = (function() {
    var $element = '.btn-icon-clipboard',
        $btn = $($element);

    function init($this) {
        $this.tooltip().on('mouseleave', function() {
            $this.tooltip('hide');
        });

        var clipboard = new ClipboardJS($element);

        clipboard.on('success', function(e) {
            $(e.trigger)
                .attr('title', 'Copied!')
                .tooltip('_fixTitle')
                .tooltip('show')
                .attr('title', 'Copy to clipboard')
                .tooltip('_fixTitle')

            e.clearSelection()
        });
    }

    if ($btn.length) {
        init($btn);
    }

})();

var Navbar = (function() {

    var $nav = $('.navbar-nav, .navbar-nav .nav');
    var $collapse = $('.navbar .collapse');
    var $dropdown = $('.navbar .dropdown');

    function accordion($this) {
        $this.closest($nav).find($collapse).not($this).collapse('hide');
    }

    function closeDropdown($this) {
        var $dropdownMenu = $this.find('.dropdown-menu');

        $dropdownMenu.addClass('close');

        setTimeout(function() {
            $dropdownMenu.removeClass('close');
        }, 200);
    }

    $collapse.on({
        'show.bs.collapse': function() {
            accordion($(this));
        }
    })

    $dropdown.on({
        'hide.bs.dropdown': function() {
            closeDropdown($(this));
        }
    })

})();

var NavbarCollapse = (function() {

    var $nav = $('.navbar-nav'),
        $collapse = $('.navbar .navbar-custom-collapse');

    function hideNavbarCollapse($this) {
        $this.addClass('collapsing-out');
    }

    function hiddenNavbarCollapse($this) {
        $this.removeClass('collapsing-out');
    }

    if ($collapse.length) {
        $collapse.on({
            'hide.bs.collapse': function() {
                hideNavbarCollapse($collapse);
            }
        })

        $collapse.on({
            'hidden.bs.collapse': function() {
                hiddenNavbarCollapse($collapse);
            }
        })
    }

    var navbar_menu_visible = 0;

    $(".sidenav-toggler").click(function() {
        if (navbar_menu_visible == 1) {
            $('body').removeClass('nav-open');
            navbar_menu_visible = 0;
            $('.bodyClick').remove();

        } else {

            var div = '<div class="bodyClick"></div>';
            $(div).appendTo('body').click(function() {
                $('body').removeClass('nav-open');
                navbar_menu_visible = 0;
                $('.bodyClick').remove();
            });

            $('body').addClass('nav-open');
            navbar_menu_visible = 1;
        }
    });
})();

var FormControl = (function() {
    var $input = $('.form-control');
    function init($this) {
        $this.on('focus blur', function(e) {
            $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus'));
        }).trigger('blur');
    }
    if ($input.length) {
        init($input);
    }
})();

function previousPage() {
    history.go(-1);
}

function deleteTableRow(id)
{
    $('table#paymentTypeTable tr#' + id).remove();
    $('#paymentTypeTable').trigger('rowAddOrRemove');
}

function bookingFormStatusBtn() {
    try {
        $("#bookingBtn").on("click", function () {
            var bookingFormId = $("#booking_form_id").val();
            var formStatusId = $("#formStatusId").children("option:selected").val();
            changeBookingFormStatus(bookingFormId, formStatusId);
        });
    }
    catch (error) {
        console.log(error);
    }
}

function changeBookingFormStatus(bookingFormId, formStatusId) {
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/definitions/bookings/change/' + bookingFormId + '',
            type: 'POST',
            data: {
                'formStatusId': formStatusId
            },
            async: false,
            dataType: 'json',
            success: function (response) {
                swal({ icon: 'success', title: 'Durum Başarıyla Güncellendi!', text: '' });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            },

            error: function () { },
        });
    } catch (error) {
        console.log(error);
    } finally { }
}

function contactFormStatusBtn(){
    try {
        $("#contactBtn").on("click", function () {
            var contactFormId = $("#contact_form_id").val();
            var formStatusId = $("#formStatusId").children("option:selected").val();
            changeContactFormStatus(contactFormId, formStatusId);
        });
    }
    catch (error) {
        console.log(error);
    }
}

function changeContactFormStatus(contactFormId, formStatusId) {
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/definitions/contactforms/change/' + contactFormId + '',
            type: 'POST',
            data: {
                'formStatusId': formStatusId
            },
            async: false,
            dataType: 'json',
            success: function (response) {
                swal({ icon: 'success', title: 'Durum Başarıyla Güncellendi!', text: '' });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            },

            error: function () { },
        });
    } catch (error) {
        console.log(error);
    } finally { }
}

function datePicker(){
    try {
        var userFormat = "YYYY-MM-DD";

        $('#reservationDate').daterangepicker({
            "autoApply": true,
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoUpdateInput": true,
            locale: {
                firstDay: 1,
                format: userFormat
            },
        });

        $('#startDate').daterangepicker({
            "autoApply": true,
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoUpdateInput": true,
            locale: {
                firstDay: 1,
                format: userFormat
            },
        });

        $('#endDate').daterangepicker({
            "autoApply": true,
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoUpdateInput": true,
            locale: {
                firstDay: 1,
                format: userFormat
            },
        });

    }
    catch (error) {
        console.log(error);
    }
}

function clockPicker(){
    $('#reservationTime').clockpicker({ autoclose: true, donetext: 'Done', placement: 'left', align: 'top' });
}

function reservationStep() {
    try {
        var frmInfo = $('#frmInfo');
        var frmInfoValidator = frmInfo.validate();

        var frmLogin = $('#frmLogin');
        var frmLoginValidator = frmLogin.validate();

        var frmMobile = $('#frmMobile');
        var frmMobileValidator = frmMobile.validate();

        $('#demo').steps({
            onChange: function (currentIndex, newIndex, stepDirection) {
                console.log('onChange', currentIndex, newIndex, stepDirection);
                // tab1
                if (currentIndex === 1) {
                    if (stepDirection === 'forward') {
                        var valid = frmLogin.valid();
                        return valid;
                    }
                    if (stepDirection === 'backward') {
                        frmLoginValidator.resetForm();
                    }
                }

                // tab2
                if (currentIndex === 2) {
                    if (stepDirection === 'forward') {
                        var valid = frmInfo.valid();
                        return valid;
                    }
                    if (stepDirection === 'backward') {
                        frmInfoValidator.resetForm();
                    }
                }

                // tab3
                if (currentIndex === 3) {
                    if (stepDirection === 'forward') {
                        var valid = frmMobile.valid();
                        return valid;
                    }
                    if (stepDirection === 'backward') {
                        frmMobileValidator.resetForm();
                    }
                }

                return true;
            },
            onFinish: function () {
                alert('Wizard Completed');
            }
        });
    }
    catch (error) {
        console.log(error);
    }
}

function getCustomerId() {
    try {
        $('#chooseCustomerModal tbody').on('click', 'td .create-registered-customer-reservation', function () {
            var selectedCustomerId = this.id;
            var patientName = $(this).attr("data-name");
            $(".close").trigger("click");
            $(this).text("Seçildi");
            $(this).addClass("btn-danger");
            $("#next-step").trigger("click");
            $(".patientName").html('<i class="fa fa-user text-primary mr-2"></i>' + patientName);
            customerID = selectedCustomerId;
        });
    }
    catch (error) {
        console.log(error);
    }
}

function getDiscountDetail() {
    try {
        $("#discountId").on("change", function () {
            var serviceCost = $("#serviceCost").val();
            var selectedId = $(this).children("option:selected").val();
            $.ajax({
                url: '/getDiscount/' + selectedId,
                type: 'get',
                dataType: 'json',
                success: function (response) {
                    if (response) {
                        $.each(response, function (key, value) {
                            var data = value;
                            if (data == null) {
                                swal({ icon: 'info', title: 'Percentage not defined!', text: '' });
                            }
                            else if(serviceCost == ""){
                                swal({ icon: 'error', title: 'Please enter the price of the service!', text: '' });
                            }
                            else if (!data.isNull) {
                                let discountPercentage = data.discount_percentage;
                                var result = (serviceCost / 100) * discountPercentage;
                                result = serviceCost - result;
                                result = result.toFixed(2);
                                console.log(result);
                                $("#serviceCost").val(result);
                                swal({ icon: 'success', title: 'Discount applied successfully!', text: '' });
                            }
                        });
                    }
                },

                error: function () { },
            });
        });
    }
    catch (error) {
        console.log(error);
    }
    finally { }
}

function addCustomertoReservationModal() {
    try {
        $('#addCustomertoReservationSave').on('click', function(){
            var customerNameSurname = $("#addCustomerModal").find('#customerNameSurname').val();
            if (customerNameSurname == ""){
                swal({ icon: 'error', title: 'Lütfen boşlukları doldurun!', text: '' });
            }
            else {
                $("#next-step").trigger("click");
                $('.add-reservation-close').trigger('click');
            }
        });
    } catch (error) {
        console.log(error);
    }
}

function createPaymentTypeOperation() {
    try {
        $('#createPaymentType').on('click', function () {
            var paymentTypeId = $("#addPaymentType").find('#paymentType').children("option:selected").val();
            var paymentTypeName = $("#addPaymentType").find('#paymentType').children("option:selected").text();
            var paymentPrice = $("#addPaymentType").find('#paymentPrice').val();

            if (paymentTypeId == "" || paymentPrice == "") {
                swal({ icon: 'error', title: 'Lütfen Boşlukları Doldurunuz!', text: '' });
            }
            else {
                var rowId = paymentTypeId;
                var markup = "<tr class='service' id='" + rowId + "'>" +
                    "<td id='" + rowId + "'>" + paymentTypeName + "</td>" +
                    "<td>" + paymentPrice + "</td>" +
                    "<td><button onclick='deleteTableRow(" + rowId + ")' class='btn btn-danger delete-btn'><i class='fa fa-window-close'></i> Kaldır</button></td>" +
                    "</tr>";

                $("#addPaymentType").find('#paymentPrice').val("");
                $('#paymentTypeTable tbody').append(markup);
                $('#paymentTypeTable').trigger('rowAddOrRemove');
            }
        });
    } catch (error) {
        console.log(error);
    }
}

function addReservationOperation() {
    try {
        $('#reservationSave').on('click', function(){
            var vehicleName     = $("#tab2").find('#vehicleId').children("option:selected").text();
            var pickupLocation  = $("#tab2").find('#pickupLocation').val();
            var returnLocation  = $("#tab2").find('#returnLocation').val();
            var reservationDate = $("#tab2").find('#reservationDate').val();
            var reservationTime = $("#tab2").find('#reservationTime').val();
            var totalCustomer   = $("#tab2").find('#totalCustomer').val();
            var sourceName      = $("#tab2").find("#sobId").children("option:selected").text();
            var therapistId     = $("#tab2").find('#therapistId').children("option:selected").val();
            var routeType       = $("#tab2").find('#routeTypeID').children("option:selected").val();
            var routeTypeName   = $("#tab2").find('#routeTypeID').children("option:selected").text();
            var reservationNote = $('#tab2').find("#note").val();

            if (routeType == "" || reservationDate == "" || reservationTime == "" || totalCustomer == "" || therapistId == "" || sourceName == ""){
                swal({ icon: 'error', title: 'Lütfen Boşlukları Doldurunuz!', text: '' });
            }
            else {
                $(".vehicle-name").text(vehicleName);
                $(".pickup_location").text(pickupLocation);
                $(".dropoff_location").text(returnLocation);
                $(".reservation-date").text(reservationDate);
                $(".reservation-time").text(reservationTime);
                $(".total-customer").text(totalCustomer);
                $(".source-name").text(sourceName);
                $(".route-type").text(routeTypeName);
                $(".reservation-note").text(reservationNote);
                $("#next-step").trigger("click");
                if (customerID == undefined) {
                    var nameSurname = $("#addCustomerModal").find('#customerNameSurname').val();
                    var phone = $("#addCustomerModal").find('#phone_get').val();
                    var country = $("#addCustomerModal").find('#country').children("option:selected").val();
                    var email = $("#addCustomerModal").find('#customerEmail').val();
                    setTimeout(() => {
                        addCustomer(nameSurname, phone, country, email);
                    }, 500);
                }
            }
        });
    }
    catch (error) {
        console.log(error);
    }
}

function completeReservation() {
    try {
        $("#completeReservation").on("click", function () {
            if (customerID != undefined) {
                setTimeout(() => {
                    //reservation
                    var vehicleId = $("#tab2").find('#vehicleId').children("option:selected").val();
                    var pickupLocation = $("#tab2").find('#pickupLocation').val();
                    var returnLocation = $("#tab2").find('#returnLocation').val();
                    var reservationDate = $("#tab2").find('#reservationDate').val();
                    var reservationTime = $("#tab2").find('#reservationTime').val();
                    var routeType       = $("#tab2").find('#routeTypeID').children("option:selected").val();

                    var totalCustomer = $("#tab2").find('#totalCustomer').val();
                    var sourceId = $('#tab2').find("#sobId").children("option:selected").val();
                    var reservationNote = $('#tab2').find("#note").val();
                    addReservation(routeType,vehicleId, pickupLocation, returnLocation, reservationDate, reservationTime, totalCustomer, customerID, sourceId, reservationNote);
                }, 500);
            }
        });
    }
    catch (error) { }
}

function addReservation(routeType, vehicleId, pickupLocation, returnLocation, reservationDate, reservationTime, totalCustomer, customerID, sourceId, reservationNote){
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/reservations/store',
            type: 'POST',
            data: {
                'vehicleId': vehicleId,
                'reservationDate': reservationDate,
                'reservationTime': reservationTime,
                'pickupLocation': pickupLocation,
                'returnLocation': returnLocation,
                'totalCustomer': totalCustomer,
                'customerId': customerID,
                'sourceId': sourceId,
                'routeTypeId': routeType,
                'reservationNote': reservationNote
            },
            async: false,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    swal({ icon: 'success', title: 'Başarılı!', text: 'Rezervasyon Başarıyla Eklendi!', timer: 1000 });
                    reservationID = response;
                    setTimeout(() => {
                        window.location.href = "/reservations/calendar";
                    }, 500);
                }
            },

            error: function () { },
        });
    } catch (error) {
        console.log(error);
    }
}

function addPaymentTypetoReservation(reservationID, paymentTypeId, paymentPrice) {
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/reservations/addPaymentTypetoReservation',
            type: 'POST',
            data: {
                'reservationId': reservationID,
                'paymentTypeId': paymentTypeId,
                'paymentPrice': paymentPrice
            },
            async: false,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    swal({ icon: 'success', title: 'Başarılı!', text: 'Ödeme Türleri Başarıyla Eklendi!', timer: 1000 });
                }
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },

            error: function () { },
        });
    } catch (error) {
        console.log(error);
    }
}

function addComission(hotelId, guideId) {
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/addComissiontoReservation',
            type: 'POST',
            data: {
                'reservationId': reservationID,
                'hotelId': hotelId,
                'guideId': guideId
            },
            async: false,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    // swal({ icon: 'success', title: 'Başarılı!', text: 'Customer Added Successfully!', timer: 1000 });
                    customerID = response;
                }
            },

            error: function () { },
        });
    } catch (error) {
        console.log(error);
    }
}

function addCustomer(nameSurname, phone, country, email) {
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/customers/save',
            type: 'POST',
            data: {
                'nameSurname': nameSurname,
                'phone': phone,
                'country': country,
                'email': email
            },
            async: false,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    // swal({ icon: 'success', title: 'Başarılı!', text: 'Customer Added Successfully!', timer: 1000 });
                    customerID = response;
                }
            },

            error: function () { },
        });
    } catch (error) {
        console.log(error);
    }
}

function addPaymentTypeOperation() {
    try {
        $('#addPaymentTypetoReservationSave').on('click', function () {
            var reservationID = $("#addPaymentTypeModal").find('#reservation_id').val();
            var paymentTypeId = $("#addPaymentTypeModal").find('#paymentType').children("option:selected").val();
            var paymentPrice = $("#addPaymentTypeModal").find('#paymentPrice').val();
            if (paymentTypeId == "" || paymentPrice == "") {
                swal({ icon: 'error', title: 'Lütfen Boşlukları Doldurunuz!', text: '' });
            }
            else {
                addPaymentTypetoReservation(reservationID, paymentTypeId, paymentPrice);
                // swal({ icon: 'success', title: 'Başarılı!', text: 'Ödeme Türü Başarıyla Eklendi!', timer: 1000 });
                // setTimeout(() => {
                //     location.reload();
                // }, 1500);
            }
        });
    } catch (error) {
        console.log(error);
    }
}
function scrollToReservation() {
    var div = document.getElementById("reservation");
    div.scrollIntoView({ behavior: "smooth", block: "center" });
}
function scrollToCiro() {
    var div = document.getElementById("ciro");
    div.scrollIntoView({ behavior: "smooth", block: "center" });
}

function addcustomerReservation() {
    try {
        $('#saveCustomerReservation').on('click', function () {
            var reservationID = $('#reservation_id').val();
            var customersId = $("#addCustomer").find('#customerId').children("option:selected").val();
            setTimeout(() => {
                addCustomertoReservation(reservationID, customersId);
            }, 200);
        });
    } catch (error) {
        console.log(error);
    }
}

function addCustomertoReservation(reservationID, customersId){
    try {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/definitions/reservations/addCustomertoReservation',
            type: 'POST',
            data: { 'reservation_id': reservationID, 'customer_id': customersId },
            async: false,
            dataType: 'json',
            success: function (response) {
                if (response) {
                    swal({ icon: 'success', title: 'Customer Added Successfully!', text: '', timer: 1000 });
                    location.reload();
                }
            },

            error: function () { },
        });
    } catch (error) {
        console.log(error);
    }
}
let date_ob = new Date();
let date = ("0" + date_ob.getDate()).slice(-2);
let month = ("0" + (date_ob.getMonth() + 1)).slice(-2);
let year = date_ob.getFullYear();
var now_date = (date + "_" + month + "_" + year);
function tableSourceExcel() {
    /* Get table data */
    var wb = XLSX.utils.table_to_book(document.getElementById('tableSource'), {sheet:"Sheet JS"});

    /* Save to file */
    var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
    saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'Rezervasyon_Kaynak_Özetleri_Raporu_'+now_date+'.xlsx');
}

function tableDataExcel() {
    /* Get table data */
    var wb = XLSX.utils.table_to_book(document.getElementById('tableData'), {sheet:"Sheet JS"});

    /* Save to file */
    var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
    saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'Tarihe_Göre_Rezervasyon_Adetleri_Raporu_'+now_date+'.xlsx');
}
function vehicleExcel() {
    /* Get table data */
    var wb = XLSX.utils.table_to_book(document.getElementById('basic-btn'), {sheet:"Sheet JS"});

    /* Save to file */
    var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
    saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'Araç_Raporu_'+now_date+'.xlsx');
}
function tableCountryExcel() {
    /* Get table data */
    var wb = XLSX.utils.table_to_book(document.getElementById('tableCountry'), {sheet:"Sheet JS"});

    /* Save to file */
    var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;
    }
    saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'Rezervasyon_Ülke_Özetleri_Raporu_'+now_date+'.xlsx');
}
