<script src="{{url('adminback/js/jquery.min.js')}}"></script>
<script src="{{url('adminback/js/popper.min.js')}}"></script>
<script src="{{url('adminback/js/moment.min.js')}}"></script>
<script src="{{url('adminback/js/vi.min.js')}}"></script>
<script src="{{url('adminback/js/bootstrap.min.js')}}"></script>
<script src="{{url('adminback/js/simplebar.min.js')}}"></script>
<script src='{{url('adminback/js/daterangepicker.js')}}'></script>
<script src='{{url('adminback/js/jquery.stickOnScroll.js')}}'></script>
<script src="{{url('adminback/js/tinycolor-min.js')}}"></script>
<script src="{{url('adminback/js/config.js')}}"></script>
<script src="{{url('adminback/js/apps.js')}}"></script>
<script src="{{url('adminback/js/d3.min.js')}}"></script>
<script src="{{url('adminback/js/topojson.min.js')}}"></script>
<script src="{{url('adminback/js/datamaps.all.min.js')}}"></script>
<script src="{{url('adminback/js/datamaps-zoomto.js')}}"></script>
<script src="{{url('adminback/js/datamaps.custom.js')}}"></script>
<script src="{{url('adminback/js/Chart.min.js')}}"></script>
<script src="{{url('adminback/js/gauge.min.js')}}"></script>
<script src="{{url('adminback/js/jquery.sparkline.min.js')}}"></script>
<script src="{{url('adminback/js/apexcharts.min.js')}}"></script>
<script src="{{url('adminback/js/apexcharts.custom.js')}}"></script>
<script src='{{url('adminback/js/jquery.mask.min.js')}}'></script>
<script src='{{url('adminback/js/select2.min.js')}}'></script>
<script src='{{url('adminback/js/jquery.steps.min.js')}}'></script>
<script src='{{url('adminback/js/jquery.validate.min.js')}}'></script>
<script src='{{url('adminback/js/jquery.timepicker.js')}}'></script>
<script src='{{url('adminback/js/dropzone.min.js')}}'></script>
<script src='{{url('adminback/js/uppy.min.js')}}'></script>
<script src='{{url('adminback/js/quill.min.js')}}'></script>
<script src='{{url('adminback/js/jquery.dataTables.min.js')}}'></script>
<script src='{{url('adminback/js/dataTables.bootstrap4.min.js')}}'></script>
<script src='{{url('adminback/js/fullcalendar.js')}}'></script>
<script src='{{url('adminback/js/fullcalendar.custom.js')}}'></script>

<script>
    Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
    Chart.defaults.global.defaultFontColor = colors.mutedColor;
</script>

@yield('script')

<script>
    $('.select2').select2({
        theme: 'bootstrap4',
    });
    $('.select2-multi').select2({
        multiple: true,
        theme: 'bootstrap4',
        closeOnSelect: false,
    });

    // Ngăn không cho người dùng bỏ chọn các mục đã chọn
    $('.select2-multi').on('select2:select', function(e) {
        var selectedElement = e.params.data.element;
        var $selectedElement = $(selectedElement);

        // Vô hiệu hóa mục đã chọn
        $selectedElement.prop('disabled', true);
        $(this).trigger('change.select2'); // Cập nhật Select2
    });

    // Đảm bảo rằng các mục đã chọn vẫn bị vô hiệu hóa khi mở Select2
    $('.select2-multi').on('select2:open', function() {
        var selectedOptions = $(this).find(':selected');
        selectedOptions.each(function() {
            $(this).prop('disabled', true);
        });
    });

    $('.drgpicker').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
    $('.time-input').timepicker({
        'scrollDefault': 'now',
        'zindex': '9999', /* fix modal open */
        'showMeridian': false
    });
    /** date range picker */
    if ($('.datetimes').length) {
        $('.datetimes').daterangepicker({
            timePicker: true,
            startDate: moment(),
            endDate: moment(),
            locale: {
                format: 'DD/MM/Y'
            }
        });
    }

    $('.input-placeholder').mask("00/00/0000", {
        placeholder: "__/__/____"
    });
    $('.input-zip').mask('00000-000', {
        placeholder: "____-___"
    });
    $('.input-money').mask("#.##0", {
        reverse: true
    });
    $('.input-phoneus').mask('(000) 000-0000');
    $('.input-masv').mask('BIT-000000');
    $('.input-mixed').mask('AAA 000-S0S');
    $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: true
            }
        },
        placeholder: "___.___.___.___"
    });
    // editor
    var editor = document.getElementById('editor');
    if (editor) {
        var toolbarOptions = [
            [{
                'font': []
            }],
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{
                    'header': 1
                },
                {
                    'header': 2
                }
            ],
            [{
                    'list': 'ordered'
                },
                {
                    'list': 'bullet'
                }
            ],
            [{
                    'script': 'sub'
                },
                {
                    'script': 'super'
                }
            ],
            [{
                    'indent': '-1'
                },
                {
                    'indent': '+1'
                }
            ], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction
            [{
                    'color': []
                },
                {
                    'background': []
                }
            ], // dropdown with defaults from theme
            [{
                'align': []
            }],
            ['clean'] // remove formatting button
        ];
        var quill = new Quill(editor, {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    }
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

</script>
<script>
    var uptarg = document.getElementById('drag-drop-area');
    if (uptarg) {
        var uppy = Uppy.Core().use(Uppy.Dashboard, {
            inline: true,
            target: uptarg,
            proudlyDisplayPoweredByUppy: false,
            theme: 'dark',
            width: 770,
            height: 210,
            plugins: ['Webcam']
        }).use(Uppy.Tus, {
            endpoint: 'https://master.tus.io/files/'
        });
        uppy.on('complete', (result) => {
            console.log('Upload complete! We’ve uploaded these files:', result.successful)
        });
    }

</script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'UA-56159088-1');
</script>

<script>
    var dataTableAllText = "Tất cả";

    document.addEventListener('DOMContentLoaded', function () {
    var table = $('#dataTable-1').DataTable();
    if ($.fn.DataTable.isDataTable('#dataTable-1')) {
        table.destroy();
    }
    $('#dataTable-1').DataTable({
        language: {
            oPaginate: {
                sNext: "Tiếp",
                sPrevious: "Trước"
            },
            sEmptyTable: "Không có dữ liệu trong bảng",
            sInfo: "Hiển thị _START_ đến _END_ trong số _TOTAL_ mục",
            sInfoEmpty: "Hiển thị 0 đến 0 trong 0 mục",
            infoFiltered: '(được lọc từ tổng số  _MAX_ mục)',
            sSearch: "Tìm kiếm",
            sLengthMenu: "Hiển thị _MENU_",
            zeroRecords: 'Không tìm thấy dữ liệu',
        },
        autoWidth: true,
        "lengthMenu": [
            [8, 16, 32, -1],
            [8, 16, 32, dataTableAllText]
        ]
    });
});
</script>
