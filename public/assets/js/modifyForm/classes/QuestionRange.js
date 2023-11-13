class QuestionRange extends Question {
    constructor(
        label,
        order,
        toolid = -1,
        type = "range",
        min = 1,
        max = 5,
        step = 1
    ) {
        super(label, order, toolid, type);
        this.min = min;
        this.max = max;
        this.step = step;
    }

    displayRange() {
        htmlRange =
            "<div><ul>" +
            "<li>Minimum :" +
            this.min +
            "</li><li>Maximum : " +
            this.max +
            "</li><li>Ganularité : " +
            this.step +
            "</li></ul></div>";
    }
}
