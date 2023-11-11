class Proposition {
    constructor(value, order) {
        this.value = value;
        this.order = order;
    }

    displayProposition(name) {
        let htmlValue =
            "<li id='" +
            name +
            "prop" +
            this.order +
            "'>" +
            this.value +
            "</li>";
        return htmlValue;
    }
}
