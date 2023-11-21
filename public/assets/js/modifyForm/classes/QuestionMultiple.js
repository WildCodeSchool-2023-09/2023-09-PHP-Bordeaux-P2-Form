class QuestionMultiple extends Question {
    constructor(label, order, toolid = -1, type = "radio", propositions = []) {
        super(label, order, toolid, type);
        this.propositions = propositions;
    }

    addProposition(proposition) {
        this.propositions.push(proposition);
    }

    addPropositionsFromArray(propositionsArray) {
        propositionsArray.forEach((proposition) => {
            let newProposition = new Proposition(
                proposition.tool_option,
                proposition.choice_order,
                proposition.id
            );
            this.addProposition(newProposition);
        });
    }

    displayQuestion() {
        let id = "savedQuestion" + this.order;
        this.order;
        let htmlValue =
            "<div class='newQuestion'><div class='savedQuestion' id='" +
            id +
            "' toolid='" +
            this.toolid +
            "' tooltype='" +
            this.type +
            "' contenteditable='true'>" +
            this.label +
            "</div><div class='formButtons'><button class='buttonSuppr' id='buttonSuppr" +
            this.order +
            "'>-</button></div></div>" +
            "<ul><button class='addProposition' id='proposition'>+</button>";
        this.propositions.forEach((a) => {
            let toWrite = a.displayProposition(id);
            htmlValue += toWrite;
        });

        htmlValue += "</ul></div>";
        return htmlValue;
    }

    sort() {
        this.proposition.sort((a, b) => a.order - b.order);
        let counter = 1;
        this.propositions.forEach((elt) => {
            elt.order = counter;
            counter += 1;
        });
    }

    remove(value) {
        for (let i = 0; i < this.propositions.length; i++) {
            if (this.propositions[i].value === value) {
                this.propositions.splice(i, 1);
                break;
            }
        }
        this.sort();
    }

    modify(nb, newValue) {
        for (let i = 0; i < this.propositions.length; i++) {
            if (this.propositions[i].order == nb) {
                this.propositions[i].value = newValue;
                break;
            }
        }
    }

    changeOrder(element, newOrder) {
        this.proposition.forEach((elt) => {
            if (elt.value === element.value) {
                elt.order = newOrder;
            } else if (elt.order >= newOrder) {
                elt.order += 1;
            }
        });
        this.sort();
    }

    createQuestionRangeFrom() {
        let questionRange = new QuestionRange(
            this.label,
            this.order,
            this.toolid
        );
    }
}
