import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $(".delete-note").on('click', this.deleteNote);
        $(".edit-note").on('click', this.editNote.bind(this));
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
    editNote(event) {
        var note = $(event.target).parents("li");
        note.data('state') == 'editable' ? this.makeNoteReadOnly(note) : this.makeNoteEditable(note);
    }
    makeNoteEditable(note) {
        note.find('.edit-note').html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        note.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass("note-active-field");
        note.find(".update-note").addClass("update-note--visible");
        note.data('state', 'editable');
    }
    makeNoteReadOnly(note) {
        note.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
        note.find('.note-title-field, .note-body-field').attr('readonly', 'readonly').removeClass("note-active-field");
        note.find(".update-note").removeClass("update-note--visible");
        note.data('state', 'cancel');
    }

}
export default MyNotes;