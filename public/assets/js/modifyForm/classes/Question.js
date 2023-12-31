class Question {
    constructor(label, order, toolid = -1, type = "text") {
        this.label = label;
        this.order = order;
        this.type = type;
        this.toolid = toolid;
        /*toolid par défaut de -1 : la question n'existe pas dans la bdd
         */
    }

    displayQuestion() {
        return (
            "<div class='newQuestion'><div class='savedQuestion' id='savedQuestion" +
            this.order +
            "' toolid='" +
            this.toolid +
            "' tooltype='" +
            this.type +
            "' contenteditable='true'>" +
            this.label +
            "</div><div class='formButtons'><button class='buttonSuppr' id='buttonSuppr" +
            this.order +
            "'>-</button></div></div>"
        );
    }
}
