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
        if (likeBox.data('exists') == 'yes') {
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
    deleteLike() {
        $.ajax({
            url: mainData.root_url + '/wp-json/university/v1/manageLike',
            type: 'DELETE',
            success: (response) => {
                console.log(response);
            },
            error: (response) => {
                console.log(response);
            }
        });
    }
}
export default Like;