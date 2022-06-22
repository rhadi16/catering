$(document).ready(function(){
    $('.sidenav').sidenav();

    $('.modal').modal();

    $('select').formSelect();

    $('.swal2-popup').find('div[class$="select-wrapper"]').remove();
});