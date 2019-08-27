$(document).ready(() => {
    $('.js-like-dish').on('click', (e) => {
        e.preventDefault();
        let $link = $(e.currentTarget);
        $link.toggleClass('fa-heart-o').toggleClass('fa-heart');
        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done((data) => {
            $('.js-like-dish-count').html(data.likes);
        })
    });
});