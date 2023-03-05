<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"
    integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    function select2Conf(url, placeholder) {
        return {
            theme: "bootstrap-5",
            placeholder,
            minimumInputLength: 0,
            ajax: {
                url,
                dataType: 'json',
                delay: 250,
                cache: true,
                data: function(params) {
                    var query = {
                        name: params.term,
                        type: 'public'
                    }
                    return query;
                },
                processResults: function(data) {
                    var results = $.map(data, function(obj) {
                        obj.id_original = obj.id;
                        obj.id = obj.code;
                        obj.text = obj.name;

                        return obj;
                    });

                    return {
                        results
                    };
                }
            }
        }
    }

    function provinceSelect() {
        return $('#province').select2(select2Conf('{{ route('address.provinces') }}', 'Pilih Provinsi'))
            .on('select2:select', (e) => {
                $('#province_name').val(e.params.data.name)
                // Reset City, District, Village
                $('#city').val(null).trigger('change')
                $('#district').val(null).trigger('change')
                $('#village').val(null).trigger('change')
                $('#village_id').val(null)
            })
    }

    function citySelect(provinceCode) {
        return $('#city')
            .select2(select2Conf('{{ route('address.cities') }}/' + provinceCode, 'Pilih Kabupaten/Kota'))
            .prop('disabled', false)
            .on('select2:select', (e) => {
                $('#city_name').val(e.params.data.name)
            })
    }

    function districtSelect(cityCode) {
        return $('#district')
            .select2(select2Conf('{{ route('address.districts') }}/' + cityCode, 'Pilih Kecamatan'))
            .prop('disabled', false).on('select2:select', (e) => {
                $('#district_name').val(e.params.data.name)
            })
    }

    function villageSelect(districtCode) {
        return $('#village')
            .select2(select2Conf('{{ route('address.villages') }}/' + districtCode, 'Pilih Desa/Kelurahan'))
            .prop('disabled', false).on('select2:select', (e) => {
                $('#village_name').val(e.params.data.name)
            })
    }

    $(document).ready(() => {
        provinceSelect()
            .on('select2:select', (e) => {
                // City Select
                citySelect(e.params.data.code)
                    .on('select2:select', (e) => {
                        // District Select
                        districtSelect(e.params.data.code)
                            .on('select2:select', (e) => {
                                // Village select
                                villageSelect(e.params.data.code)
                                    .on('select2:select', (e) => {
                                        $('#village_id').val(e.params.data.id_original)
                                    })
                            })
                    })

            })

        // Default value when data has been selected
        var provinceCode = $('#province').find(':selected').val()
        citySelect(provinceCode)

        var cityCode = $('#city').find(':selected').val()
        districtSelect(cityCode)

        var districtCode = $('#district').find(':selected').val()
        villageSelect(districtCode)
    })
</script>
