import $ from 'jquery';

class MyNotes {
    constructor() {
        this.events();
    }

    events() {
        $(".delete-note").on('click', this.deleteNote);
    }
    deleteNote() {
        alert("You clicked delete!");
    }
}
export default MyNotes;