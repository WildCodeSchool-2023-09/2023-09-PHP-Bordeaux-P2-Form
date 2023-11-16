class QuestionRange extends QuestionMultiple {
    constructor(label, order, toolid = -1, type = "range", propositions = []) {
        super(label, order, toolid, type, propositions);
    }

    displayQuestion() {
        let id = "savedQuestion" + this.order;
        let selfHtml =
            "<div class='newQuestion'><div class='savedQuestion range' id='savedQuestion" +
            this.order +
            "' toolid='" +
            this.toolid +
            "' tooltype='" +
            this.type +
            "' contenteditable='true'>" +
            this.label +
            "</div><div class='formButtons'><button class='buttonSuppr' id='buttonSuppr" +
            this.order +
            "'>-</button></div></div>";
        selfHtml += this.displayRange(id);

        return selfHtml;
    }

    displayRange(id) {
        let htmlRange =
            "<div><ul>" +
            "<li id='" +
            id +
            "prop" +
            this.order +
            "'>Minimum :" +
            this.propositions[0].value +
            "</li><li id='" +
            id +
            "prop" +
            this.order +
            "'>Maximum : " +
            this.propositions[1].value +
            "</li><li id='" +
            id +
            "prop" +
            this.order +
            "'>Ganularité : " +
            this.propositions[2].value +
            "</li></ul></div>";
        return htmlRange;
    }
}
