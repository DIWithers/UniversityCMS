import $ from 'jquery';

class Student {
    constructor() {
        this.events();
        console.log($("#message"));
        if ($("#message")) console.log("yes");
    }
    events() {
        $("#message")
        .fadeOut(2000, function() { $(this).slideUp(4000, 'linear'); })
    }
}

export default Student;