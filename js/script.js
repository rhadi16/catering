const desc_in = $('.desc-in').data('flashdata');
if (desc_in == "success-send") {
    Swal.fire(
      'Berhasil Mengirim Email!',
      'Silahkan Cek Email Anda Untuk Melihat Balasan Dari Admin',
      'success'
    )
} else if (desc_in == "success-reg") {
    Swal.fire(
      'Berhasil Melakukan Registrasi!',
      'Silahkan Login Sebagai Pelanggan',
      'success'
    )
}

$(document).ready(function(){
    $('.sidenav').sidenav();

    $('.modal').modal();

    $('.tooltipped').tooltip();

    $('select').formSelect();

    $('.swal2-popup').find('div[class$="select-wrapper"]').remove();
});