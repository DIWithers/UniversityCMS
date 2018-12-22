import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $(".delete-note").on('click', this.deleteNote);
    }
    deleteNote(event) {
        var note = $(event.target).parents("li");
        $.ajax({
            beforeSend: (xhr) => xhr.setRequestHeader('X-WP-Nonce', mainData.nonce),
            url: mainData.root_url + '/wp-json/wp/v2/note/' + note.data('id'),
            type: 'DELETE',
            success: (response) => {
                note.slideUp();
                console.log("Success: ", response);
            },
            error: (response) => {
                console.log("Error: ", response)
            }
        })
    }
}
export default MyNotes;