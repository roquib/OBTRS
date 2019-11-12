require("./bootstrap");

import "jquery-ui/ui/widgets/datepicker.js";
import "jquery-ui/ui/widgets/autocomplete.js";
import "bootstrap-datepicker/dist/js/bootstrap-datepicker.js";
// import "jquery-ui/ui/"
import VueRouter from "vue-router";
import UserComponent from "./components/Admin/Users.vue";
import ProfileComponent from "./components/Admin/Profile.vue";
import DashboardComponent from "./components/Dashboard.vue";
import GroupComponent from "./components/Admin/Group.vue";
import CategoryComponent from "./components/Admin/Category.vue";
import AuthorComponent from "./components/Admin/Author.vue";
import DetailComponent from "./components/Admin/Detail.vue";
import PublicationComponent from "./components/Admin/Publication.vue";
import ProductComponent from "./components/Admin/Product.vue";
import SupplierComponent from "./components/Admin/Supplier.vue";
import OperatorComponent from "./components/Admin/Operator.vue";
import CityComponent from "./components/Admin/City.vue";
import BoardingComponent from "./components/Admin/Boarding.vue";
import CounterComponent from "./components/Admin/Counter.vue";
import RouteComponent from "./components/Admin/Route.vue";
import TicketComponent from "./components/Admin/Ticket.vue";
import OriginCityComponent from "./components/Admin/OriginCity.vue";
import DestinationCityComponent from "./components/Admin/DestinationCity.vue";
import TripPointComponent from "./components/Admin/TripPoint.vue";
import TripRouteComponent from "./components/Admin/TripRoute.vue";
import PurchaseComponent from "./components/Admin/Purchase.vue";
import PurchaseLComponent from "./components/Admin/PurchaseList.vue";

// Date format
import moment from "moment";
import { Form, HasError, AlertError } from "vform";
import VueProgressBar from "vue-progressbar";
// ES6 Modules or TypeScript
import swal from "sweetalert2";
import VueSelect from "vue-cool-select";

window.Vue = require("vue");
window.Form = Form;
window.Fire = new Vue();
window.swal = swal;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component("pagination", require("laravel-vue-pagination"));
Vue.use(VueRouter);
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "5px"
});
const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});
window.toast = toast;
Vue.use(VueSelect, {
    theme: "bootstrap" // or 'material-design'
});

Vue.filter("upText", function(text) {
    return text.toUpperCase();
});

Vue.filter("capitalize", function(text) {
    return text == null ? "" : text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter("myDate", function(text) {
    return moment(text).format("MMM / DD / YYYY");
});

Vue.filter("bdCurrency", function(number) {
    const formatter = new Intl.NumberFormat("en-BD", {
        minimumFractionDigits: 2
    }).format(number);
    return formatter;
});
// window.Fire = new Vue();

Vue.component(
    "example-component",
    require("./components/Dashboard.vue").default
);

const user = new Vue({
    el: "#vue-user",
    data: {
        cartTotal: 2
    },

    mountant: {
        addCart() {
            this.cartTotal++;
        }
    },

    components: {
        "user-component": UserComponent,
        "profile-component": ProfileComponent,
        "dashboard-component": DashboardComponent,
        "group-component": GroupComponent,
        "category-component": CategoryComponent,
        "author-component": AuthorComponent,
        "detail-component": DetailComponent,
        "publication-component": PublicationComponent,
        "product-component": ProductComponent,
        "supplier-component": SupplierComponent,
        "counter-component": CounterComponent,
        "origincity-component": OriginCityComponent,
        "destinationcity-component": DestinationCityComponent,
        "route-component": RouteComponent,
        "trip-point-component": TripPointComponent,
        "trip-route-component": TripRouteComponent,
        "city-component": CityComponent,
        "ticket-component": TicketComponent,
        "operator-component": OperatorComponent,
        "boarding-component": BoardingComponent,
        "purchase-component": PurchaseComponent,
        "purchase-list-component": PurchaseLComponent
    }
});
