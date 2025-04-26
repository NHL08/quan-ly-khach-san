@extends('back.template.master')
@section('title', 'Cài đặt thanh toán')
@section('pays', 'active')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header">
        <h2 class="card-title">Cài đặt thanh toán</h2>
        @if(Session::has('flash_message'))
        <div class="alert alert-{!! Session::get('flash_level') !!}" role="alert">
            {!! Session::get('flash_message') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        @endif
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ url('admin/settings/pay') }}" method="post">
                    {!! csrf_field() !!}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name_card">Tên tài khoản <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{$pay->name_card}}" name="name_card" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="number_card">Số tài khoản <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="number" value="{{$pay->number_card}}" name="number_card" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <input type="hidden" name="name_bank" id="name_bank">
                            <label for="address_card">Tại <strong style="color: red">*</strong></label>
                            <select id="address_card" name="address_card" class="form-control">
                                <option value="">Chọn ngân hàng</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="number_bank">Mã ngân hàng <strong style="color: red">*</strong></label>
                            <input autocomplete="off" disabled type="text" value="{{$pay->number_bank}}" name="number_bank" id="number_bank" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="branch_card">Chi nhánh <strong style="color: red">*</strong></label>
                            <input autocomplete="off" type="text" value="{{$pay->branch_card}}" name="branch_card" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Chỉnh sửa</button>

                    @if (Session::has('flash_level') == 'success')
                    <button type="button" id="printButton" class="btn btn-secondary" data-toggle="modal" data-target="#thanhtoanModal">Test thanh toán</button>
                    <div class="modal fade" id="thanhtoanModal" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="defaultModalLabel">Test thanh toán</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body d-flex">
                                    {{-- img qr --}}
                                    <img src="https://api.vietqr.io/image/{{ $number_bank }}-{{ $number_card }}-VMvoWhr.jpg?accountName={{ str_replace('+', '%20', urlencode($name_card)) }}&amount=10000&addInfo=THANH%20TOAN%20HOA%20TEST" style="width: 300px; height: 300px;" class="navbar-brand-img brand-sm mx-auto my-4" alt="QR CODE">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn mb-2 btn-secondary" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addressCardSelect = document.getElementById('address_card');
    const numberBankInput = document.getElementById('number_bank');
    const nameBankInput = document.getElementById('name_bank');

    const defaultNameBank = nameBankInput.value;

    fetch('/api/vn/banks')
        .then(response => response.json())
        .then(data => {
            data.forEach(bank => {
                const option = document.createElement('option');
                option.value = bank.number_bank;
                option.textContent = bank.name_bank + ' - ' + bank.shortName;

                if (bank.number_bank === numberBankInput.value) {
                    option.selected = true;
                }

                addressCardSelect.appendChild(option);
            });

            const selectedOption = addressCardSelect.querySelector(`option[value="${numberBankInput.value}"]`);
            if (selectedOption) {
                nameBankInput.value = selectedOption.textContent;
            } else {
                nameBankInput.value = defaultNameBank;
            }
        })
        .catch(error => console.error('Error fetching bank data:', error));

    addressCardSelect.addEventListener('change', function() {
        numberBankInput.value = addressCardSelect.value;
        nameBankInput.value = addressCardSelect.options[addressCardSelect.selectedIndex].text;
    });
});

</script>
@stop
