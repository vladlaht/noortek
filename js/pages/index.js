$(document).ready(function () {
    $('.grid').masonry({
        itemSelector: '.post-item'
    });

    /*    Datepicker settings [START]   */
    $('.datepicker-here').datepicker({
        format: 'dd.mm.yy',
        maxViewMode: 2,
        clearBtn: true,
        autoClose: true,
        todayHighlight: true,
        minDate: moment().add(7, 'days').toDate(),
        onSelect: function () {
            if (status === 'overViewExist') {
                status = 'dataChanged';
            }
        },
        onRenderCell: function (date, cellType) {
            let disabledDays = [0, 1, 6];
            if (cellType === 'day') {
                let day = date.getDay(),
                    isDisabled = disabledDays.indexOf(day) !== -1;
                return {
                    disabled: isDisabled
                }
            }
        }
    });
    /*    Datepicker settings [END]   */

    /*    Timepicker mask [START]    */
    $('.time').mask('AB:CD', {
        translation: {
            'A': {
                pattern: /[1]/, optional: false
            },
            'B': {
                pattern: /[0-8]/, optional: false
            },
            'C': {
                pattern: /[0-5]/, optional: false
            },
            'D': {
                pattern: /[0-9]/, optional: false
            }
        },
        onKeyPress: function (a, b, c, d) {
            let m = a.match(/(\d{1})/g);
            parseInt(m[1]) === 8 ? d.translation.C.pattern = /[0-4]/ : d.translation.C.pattern = /[0-5]/;
            parseInt(m[2]) === 4 ? d.translation.D.pattern = /[0-5]/ : d.translation.D.pattern = /[0-9]/;

            let temp_value = c.val();
            c.val('');
            c.unmask().mask('AB:CD', d);
            c.val(temp_value);
        }
    });
    /*    Timepicker mask [END]    */

    /*    Smart wizard steps [START]  */
    let form = $('#nnk-booking-form');
    let wizard = $('#smartwizard');
    let preloader = $('.preloader');
    let status = 'init';
    let inputDate = $('input#date');

    $('form :input').change(function () {
        if (status === 'overViewExist') {
            status = 'dataChanged';
        }
    });

    wizard.smartWizard({
        useURLhash: false,
        showStepURLhash: false
    });

    let buttonNext = $('.sw-btn-next');
    wizard.show();
    preloader.hide();

    /*    Step 1 - Rooms cards [START]   */
    $('.room_selected').change(function () {
        $('.card').removeClass('selected');
        $('.card-button').removeClass('selected-button');
        if ($(this).is(':checked')) {
            let selectedCard = this.closest('.card');
            let selectedCardButton = this.closest('.card-button');
            $(selectedCard).addClass('selected');
            $(selectedCardButton).addClass('selected-button');
        }
    });
    /*    Step 1 - Rooms cards [END]   */

    /*    Smart wizard actions when leaving step [START]    */
    wizard.on('leaveStep', function (e, anchorObject, stepNumber) {
        let result = form.valid();
        if (result && stepNumber === 1) {
            let allItems = JSON.parse(localStorage.getItem('times'));
            let timeFrom = $('input[name=time_from]').val();
            let timeTo = $('input[name=time_until]').val();

            if (timeFrom > timeTo) {
                alert('Algus ei saa olla hilisem kui lõpuaeg');
                result = false;
                return false;
            }

            timeFrom = moment(inputDate.val() + ' ' + timeFrom, 'DD.MM.YYYY HH:ii');
            timeTo = moment(inputDate.val() + ' ' + timeTo, 'DD.MM.YYYY HH:ii');
            $.each(allItems, function (index, item) {
                if (moment(item.start).isBetween(timeFrom, timeTo) || moment(item.end).isBetween(timeFrom, timeTo)
                    || moment(timeFrom).isBetween(item.start, item.end) || moment(timeTo).isBetween(item.start, item.end)) {
                    alert('Palun sisestage aeg, mis ei kattu olemas olevate broneeringutega');
                    result = false;
                    return false;
                }
            })

        } else if (stepNumber === 5) {
            buttonNext.show();
        }
        return result;
    });
    /*    Smart wizard actions when leaving step [END]    */

    /*    Smart wizard actions when opening step [START]   */

    wizard.on('showStep', function (e, anchorObject, stepNumber) {
        if (stepNumber === 1) {
            let timetable = $('.timetable');
            timetable.fullCalendar('destroy');
            timetable.fullCalendar({
                header: {
                    left: 'title',
                    center: '',
                    right: ''
                },
                timeFormat: 'HH:mm',
                height: 150,
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                defaultDate: moment(inputDate.val(), 'DD.MM.YYYY'),
                defaultView: 'timelineDay',
                minTime: '10:00',
                maxTime: '19:00'
            });

            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'room_booking_time',
                    date: inputDate.val(),
                    room: $('input[name=room]:checked').val()
                },
                method: 'POST'
            }).done(function (response) {
                let items = [];
                $.each(response.data, function (index, value) {
                    timetable.fullCalendar('renderEvent', {
                        id: index,
                        title: value.title,
                        start: moment(value.from.date),
                        end: moment(value.to.date)
                    });
                    items.push({
                        title: value.title,
                        start: moment(value.from.date),
                        end: moment(value.to.date)
                    });
                });
                localStorage.setItem('times', JSON.stringify(items));

            }).fail(function () {
                alert('error');
            });
        } else if (stepNumber === 5) {
            buttonNext.hide();
            if (status === 'init' || status === 'dataChanged') {
                preloader.show();
                let checkboxes = document.getElementsByName('resources[]');
                let vals = [];
                for (let i = 0, n = checkboxes.length; i < n; i++) {
                    if (checkboxes[i].checked) {
                        vals.push(checkboxes[i].value);
                    }
                }
                let dataForm = {
                    date: inputDate.val(),
                    room: $('input[name=room]:checked').val(),
                    timeFrom: $('input#timeFrom').val(),
                    timeUntil: $('input#timeUntil').val(),
                    resources: vals,
                    participants: $('input#participants').val(),
                    purpose: $('input#purpose').val(),
                    info: $('textarea#info').val(),
                    firstName: $('input#firstname').val(),
                    lastName: $('input#lastname').val(),
                    phone: $('input#phone').val(),
                    email: $('input#email').val(),
                    address: $('input#address').val(),
                };
                $.ajax({
                    url: ajaxurl,
                    data: {
                        action: 'filled_form',
                        form: dataForm
                    },
                    method: 'POST'
                }).done(function (response) {
                    status = 'overViewExist';
                    let container = $('#totalSumma');
                    container.html(response.data.confirmationHTML);
                    preloader.hide();

                    $('.booking-submit-button').on('click', function () {
                        $.ajax({
                            url: ajaxurl,
                            data: {
                                action: 'booking_submit',
                                form: dataForm
                            },
                            method: 'POST'
                        }).done(function (response) {
                            $('.booking-form').html(response.data.submitSucces);

                        }).fail(function (response) {
                            console.log('error');
                            console.log(response);
                        });
                    });
                }).fail(function (response) {
                    console.log('error');
                    console.log(response);
                });
            }
        }
    });
    /*    Smart wizard actions when opening step [END]   */

    /*    Smart wizard inputs validation [START]   */

    jQuery.validator.addMethod('isValidTime', function (value) {
        return value.length > 3;
    }, 'Palun sisestage korrektne aeg');

    form.validate({
        errorContainer: '#messageBox1',
        errorElement: 'div',
        errorClass: 'is-invalid',
        validClass: 'is-valid',
        success: function (label) {
            let id = label.attr('id');
            $(id).remove();
        },
        errorPlacement: function (errorLabel, inputElement) {
            let parent = inputElement.closest('.form-group');
            let errorElement = errorLabel.removeClass('is-invalid').addClass('invalid-feedback');
            let existedErrorElements = parent.find('.invalid-feedback');
            if (existedErrorElements.length === 0) {
                parent.append(errorElement);
            } else if (existedErrorElements.length === 1 && errorElement.text() !== existedErrorElements.text()) {
                existedErrorElements.text(errorElement.text());
            }
        },
        rules: {
            room: {
                required: true
            },
            date: {
                required: true
            },
            time_from: {
                required: true,
                isValidTime: true
            },
            time_until: {
                required: true,
                isValidTime: true
            },
            participants_num: {
                required: true,
                max: 35
            },
            purpose: {
                required: true,
                maxlength: 255
            },
            info: {
                maxlength: 255
            },
            firstname: {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            lastname: {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            address: {
                required: true,
                maxlength: 255
            },
            phone: {
                required: true,
                maxlength: 15
            },
            email: {
                required: true,
                email: true,
                maxlength: 60
            },
            rules: {
                required: true
            }
        },
        messages: {
            room: {
                required: 'See väli on kohustuslik'
            },
            date: {
                required: 'See väli on kohustuslik'
            },
            time_from: {
                required: 'See väli on kohustuslik'
            },
            time_until: {
                required: 'See väli on kohustuslik'
            },
            participants_num: {
                required: 'See väli on kohustuslik',
                max: 'Ruumis võib olla maksimaalselt 35 inimest'
            },
            purpose: {
                required: 'See väli on kohustuslik',
                maxlength: 'Tekst ei tohi olla pikkem kui 255 sübmolit'
            },
            info: {
                maxlength: 'Tekst ei tohi olla pikkem kui 255 sübmolit'
            },
            firstname: {
                required: 'See väli on kohustuslik',
                minlength: 'Nime pikkus ei tohi olla alla 2 sümbolit',
                maxlength: 'Nimi ei tohi olla pikkem kui 20 sübmolit'
            },
            lastname: {
                required: 'See väli on kohustuslik',
                minlength: 'Perekonnanime pikkus ei tohi olla alla 2 sümbolit',
                maxlength: 'Nimi ei tohi olla pikkem kui 20 sübmolit'
            },
            address: {
                required: 'See väli on kohustuslik',
                maxlength: 'Aadress ei tohi olla pikkem kui 100 sübmolit'
            },
            phone: {
                required: 'See väli on kohustuslik',
                max: 'Telefoninumber ei tohi olla pikkem kui 15 sümbolit'
            },
            email: {
                required: 'See väli on kohustuslik',
                email: 'Palun sisestage valiidne email',
                maxlength: 'Eemail võib olla mitte rohkem kui 60 sümbolit pikk'
            },
            rules: {
                required: 'Peate kinnitama, et olete lugenud meie reegleid ja olete nendega nõus'
            }
        }
    });
    /*    Smart wizard inputs validation [END]   */
    /*    Smart wizard steps [END]  */
});
