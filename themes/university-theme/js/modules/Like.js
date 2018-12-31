import $ from 'jquery';

class Like {
    constructor() {
        this.events();
    }
    events() {
        $('.like-box').on('click', this.clickDispatcher.bind(this));
    }
    clickDispatcher(event) {
        var likeBox = $(event.target).closest('.like-box'); //proximity click, find closest likebox
        if (likeBox.attr('data-exists') == 'yes') {
            this.deleteLike(likeBox);
        }
        else {
            this.createLike(likeBox);
        }
    }
    createLike(likeBox) {
        $.ajax({
            beforeSend: (xhr) => xhr.setRequestHeader('X-WP-Nonce', mainData.nonce),
            url: mainData.root_url + '/wp-json/university/v1/manageLike',
            type: 'POST',
            data: {
                'professorId': likeBox.data('professor')
            },
            success: (response) => {
                var likeCount = parseInt(likeBox.find('.like-count').html(),10);
                likeCount++;
                likeBox.find('.like-count').html(likeCount);
                likeBox.attr('data-exists', 'yes');
                likeBox.attr('data-like', response);
                console.log(response);
            },
            error: (response) => {
                console.log(response);
                if (response.responseText == 'You must be logged in to create a Like.') {
                    $(".like-box-message").addClass("active");
                }
            }
        });
    }
    deleteLike(likeBox) {
        $.ajax({
            beforeSend: (xhr) => xhr.setRequestHeader('X-WP-Nonce', mainData.nonce),
            url: mainData.root_url + '/wp-json/university/v1/manageLike',
            data: {
                'like': likeBox.attr('data-like')
            },
            type: 'DELETE',
            success: (response) => {
                var likeCount = parseInt(likeBox.find('.like-count').html(),10);
                likeCount--;
                likeBox.find('.like-count').html(likeCount);
                likeBox.attr('data-exists', 'no');
                likeBox.attr('data-like', '');
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }
}
export default Like;