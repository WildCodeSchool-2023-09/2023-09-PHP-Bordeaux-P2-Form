class Questions {
    array = [];

    add(element) {
        this.array.push(element);
        this.sort();
    }

    remove(label) {
        for (let i = 0; i < this.array.length; i++) {
            if (this.array[i].label === label) {
                this.array.splice(i, 1);
                break;
            }
        }
        this.sort();
    }

    modify(nb, newLabel) {
        for (let i = 0; i < this.array.length; i++) {
            if (this.array[i].order == nb) {
                this.array[i].label = newLabel;
                break;
            }
        }
    }

    changeOrder(element, newOrder) {
        this.array.forEach((elt) => {
            if (elt.label === element.label) {
                elt.order = newOrder;
            } else if (elt.order >= newOrder) {
                elt.order += 1;
            }
        });
        this.sort();
    }

    sort() {
        this.array.sort((a, b) => a.order - b.order);
        let counter = 1;
        this.array.forEach((elt) => {
            elt.order = counter;
            counter += 1;
        });
    }

    display(htmlElement) {
        htmlElement.innerHTML = "";
        this.array.forEach((elt) => {
            htmlElement.innerHTML += elt.displayQuestion();
        });
    }

    addFromArray(fromPHP) {
        fromPHP.forEach((obj) => {
            let newQuestion;
            if (obj.propositions != undefined) {
                newQuestion = new QuestionMultiple(
                    obj.label,
                    obj.order_tool,
                    obj.id,
                    obj.tool_input_id
                );
                newQuestion.addPropositionsFromArray(obj.propositions);
            } else {
                newQuestion = new Question(
                    obj.label,
                    obj.order_tool,
                    obj.id,
                    obj.tool_input_id
                );
            }
            this.add(newQuestion);
        });
    }
}
