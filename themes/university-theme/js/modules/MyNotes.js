import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $(".delete-note").on('click', this.deleteNote);
        $(".edit-note").on('click', this.editNote.bind(this));
        $(".update-note").on('click', this.updateNote.bind(this));
        $(".submit-note").on('click', this.createNote.bind(this));
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
    updateNote(event) {
        var note = $(event.target).parents("li");
        var updatedPost = {
            'title': note.find(".note-title-field").val(),
            'content': note.find('.note-body-field').val()
        }
        $.ajax({
            beforeSend: (xhr) => xhr.setRequestHeader('X-WP-Nonce', mainData.nonce),
            url: mainData.root_url + '/wp-json/wp/v2/note/' + note.data('id'),
            type: 'POST',
            data: updatedPost,
            success: (response) => {
                this.makeNoteReadOnly(note);
                console.log("Success: ", response);
            },
            error: (response) => {
                console.log("Error: ", response)
            }
        })
    }
    createNote(event) {
        var newPost = {
            'title': $(".new-note-title").val(),
            'content': $(".new-note-body").val(),
            'status': 'publish'
        }
        $.ajax({
            beforeSend: (xhr) => xhr.setRequestHeader('X-WP-Nonce', mainData.nonce),
            url: mainData.root_url + '/wp-json/wp/v2/note/',
            type: 'POST',
            data: newPost,
            success: (response) => {
                $(".new-note-title, .new-note-body").val(""); //clear text fields
                $(`
                    <li data-id="${response.id}">
                        <input readonly class="note-title-field" value="${response.title.raw}" />
                        <span class="edit-note">
                            <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                        </span>
                        <span class="delete-note">
                            <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                        </span>
                        <textarea readonly class="note-body-field">${response.content.raw}</textarea>
                        <span class="update-note btn btn--blue btn--small">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i> Save
                        </span>
                    </li>
                `)
                .prependTo("#my-notes").hide().slideDown();
                console.log("Success: ", response);
            },
            error: (response) => {
                console.log("Error: ", response)
            }
        })
    }
}
export default MyNotes;