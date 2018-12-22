import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $(".delete-note").on('click', this.deleteNote);
    }
    deleteNote() {
        $.ajax({
            beforeSend: (xhr) => xhr.setRequestHeader('X-WP-Nonce', mainData.nonce),
            url: mainData.root_url + '/wp-json/wp/v2/note/141',
            type: 'DELETE',
            success: (response) => {
                console.log("Success: ", response);
            },
            error: (response) => {
                console.log("Error: ", response)
            }
        })
    }
}
export default MyNotes;