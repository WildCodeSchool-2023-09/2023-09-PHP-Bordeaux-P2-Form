class Proposition {
    constructor(value, order, propositionId = "-1") {
        this.value = value;
        this.order = order;
        this.propositionId = propositionId;
    }

    displayProposition(name) {
        let htmlValue =
            "<li id='" +
            name +
            "prop" +
            this.order +
            "' propId='" +
            this.questionId +
            "'>" +
            this.value +
            "</li>";
        return htmlValue;
    }
}
