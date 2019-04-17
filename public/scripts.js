function OrderManager() {
    const order = {
        meals: [],
        assortments: [],
    };

    function createOrderRow() {
        if (orderRow.meal) {
            addMeal(orderRow.meal);
        }
        if (orderRow.assortment) {
            addAssortment(orderRow.assortment);
        }
    }

    function addMeal(meal) {
        order.meals.push(meal);
    }

    function addAssortment(assortment) {
        order.assortments.push(assortment);
    }

    return { addOrderRow: createOrderRow, }
}

function DOMManager() {
    function createOrderRow() {

    }
}

(function() {
    const orderFetcher = new OrderManager();
})();


