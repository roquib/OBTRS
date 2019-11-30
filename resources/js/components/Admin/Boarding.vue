<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-indigo" style="background: #6574CD">
            <h3 class="card-title bg-indigo text-light">Boarding Table</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-success" @click="newModal">
                Add new
                <i class="fas fa-user-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>locationId</th>
                  <th>LocationName</th>
                  <th>LocationStatus</th>
                  <th>CityId</th>
                  <th>TripId</th>
                  <th>TripPointId</th>
                  <th>LocationType</th>
                  <th>LocationDate</th>
                  <th>LocationTime</th>
                  <th>CounterId</th>
                  <th>CounterName</th>
                  <th>CounterAddress</th>
                  <th>Action</th>
                </tr>
                <tr v-for="boarding in boardings" :key="boarding.id">
                  <td>{{ boarding.location_id }}</td>
                  <td>{{ boarding.location_name | capitalize }}</td>
                  <td>{{ boarding.location_status }}</td>
                  <td>{{ boarding.city_id }}</td>
                  <td>{{ boarding.trip_id }}</td>
                  <td>{{ boarding.trip_point_id }}</td>
                  <td>{{ boarding.location_type }}</td>
                  <td>{{ boarding.location_date }}</td>
                  <td>{{ boarding.location_time }}</td>
                  <td>{{ boarding.counter_id }}</td>
                  <td>{{ boarding.counter_name }}</td>
                  <td>{{ boarding.counter_address }}</td>
                  <td>
                    <a href="#" @click="editModal(boarding)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a>
                    &nbsp;
                    <a href="#" @click="deleteBoarding(boarding.id)">
                      <i class="fas fa-trash red" style="font-size: 25px;"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">
              Update Boarding
            </h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">
              Add new Boarding
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form
            @submit.prevent="editMode ? updateBoarding() : createBoarding()"
          >
            <div class="modal-body">
              <div class="form-group mb-2">
                <cool-select
                  :items="location_names"
                  id="location"
                  type="text"
                  name="location_name"
                  v-model="select_location_name"
                  placeholder="Select Trip Point Name"
                  :class="{ 'is-invalid': form.errors.has('location_name') }"
                />
                <has-error :form="form" field="location_name"></has-error>
              </div>
              <div class="form-group mb-2">
                <input
                  v-model="select_location_status"
                  type="number"
                  name="location_status"
                  placeholder="Location Status"
                  class="form-control"
                />
              </div>
              <div class="form-group mb-2">
                <select
                  title="City Required"
                  v-model="form.city_id"
                  name="city_id"
                  class="form-control form-control-sm"
                >
                  <option value="">Select City</option>
                  <option
                    v-for="city in cities"
                    :key="city.id"
                    :value="city.id"
                    >{{ city.city_name }}</option
                  >
                </select>
              </div>
              <div class="form-group mb-2">
                <input
                  v-model="form.trip_id"
                  type="text"
                  name="trip_id"
                  placeholder="Trip id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('trip_id') }"
                />
                <has-error :form="form" field="trip_id"></has-error>
              </div>
              <div class="form-group mb-2">
                <input
                  v-model="select_location_id"
                  type="text"
                  name="trip_point_id"
                  placeholder="Trip Point id"
                  class="form-control"
                />
              </div>
              <div class="form-group mb-2">
                <input
                  v-model="select_location_type"
                  type="number"
                  name="location_type"
                  placeholder="location type"
                  class="form-control"
                />
              </div>
              <div class="form-group mb-2">
                <input
                  v-model="select_location_date"
                  type="text"
                  name="location_date"
                  placeholder="location date"
                  class="form-control"
                />
              </div>

              <div class="form-group mb-2">
                <input
                  v-model="select_location_time"
                  type="text"
                  name="location_time"
                  placeholder="location time"
                  class="form-control"
                />
              </div>
              {{ getData }}
              <div class="form-group mb-2">
                <input
                  v-model="selectedCounterId"
                  type="text"
                  name="counter_id"
                  placeholder="counter id"
                  class="form-control"
                />
              </div>

              <div class="form-group mb-2">
                <cool-select
                  :items="counters"
                  id="counter"
                  type="text"
                  name="counter_name"
                  v-model="selectedCounterName"
                  placeholder="Select Counter Name"
                />
              </div>

              <div class="form-group mb-2">
                <input
                  v-model="selectedCounterAddress"
                  type="text"
                  name="counter_address"
                  placeholder="counter address"
                  class="form-control"
                />
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-danger btn-sm"
                data-dismiss="modal"
              >
                Close
              </button>
              <button
                v-show="editMode"
                type="submit"
                class="btn btn-success btn-sm"
              >
                Update
              </button>
              <button
                v-show="!editMode"
                type="submit"
                class="btn btn-primary btn-sm"
              >
                Create
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End modal -->
  </div>
</template>



<script>
  // for autocomplete
  import { CoolSelect } from "vue-cool-select";

  export default {
    computed: {
      getData() {
        if (this.selectedCounterName != null) {
          const index = this.counters.findIndex(
            counter => counter === this.selectedCounterName
          );
          this.selectedCounterName = this.counters[index];
          this.form.counter_name = this.counters[index];
          this.selectedCounterAddress = this.counter_addresses[index];
          this.form.counter_address = this.counter_addresses[index];
          this.selectedCounterId = this.counter_ids[index];
          this.form.counter_id = this.counter_ids[index];
        }
        if (this.select_location_name != null) {
          const index = this.location_names.findIndex(
            location => location === this.select_location_name
          );
          this.form.location_name = this.select_location_name;
          this.select_location_id = this.ids[index];
          this.form.location_id = this.ids[index];
          this.select_location_status = this.statuses[index];
          this.form.location_status = this.statuses[index];
          this.select_location_type = this.types[index];
          this.select_location_date = this.dates[index];
          this.select_location_time = this.times[index];
          this.form.trip_point_id = this.ids[index];
          this.form.location_type = this.types[index];
          this.form.location_date = this.dates[index];
          this.form.location_time = this.times[index];
        }
      }
    },

    mounted() {
      axios.get("api/counter-list").then(({ data }) => {
        for (let i = 0; i < data.length; i++) {
          this.counters.push(data[i]["counter_name"]);
          this.counter_addresses.push(data[i]["counter_address"]);
          this.counter_ids.push(data[i]["id"]);
        }
      });
      axios.get("api/trip-point-list").then(({ data }) => {
        for (let i = 0; i < data.length; i++) {
          this.location_names.push(data[i]["location_name"]);
          this.statuses.push(data[i]["location_status"]);
          this.types.push(data[i]["location_type"]);
          this.dates.push(data[i]["created_at"].split(" ")[0]);
          this.ids.push(data[i]["id"]);
          this.times.push(data[i]["created_at"].split(" ")[1]);
        }
      });
    },
    components: {
      CoolSelect
    },
    data() {
      return {
        editMode: false,
        boardings: {},
        ids: [],
        select_location_id: "",
        location_names: [],
        select_location_name: "",
        statuses: [],
        select_location_status: "",
        types: [],
        select_location_type: "",
        dates: [],
        select_location_date: "",
        times: [],
        select_location_time: "",
        cities: {},
        counters: [],
        selectedCounterName: "",
        selectedCounterAddress: "",
        selectedCounterId: 0,
        counter_addresses: [],
        counter_ids: [],
        form: new Form({
          id: "",
          location_name: "",
          location_id: "",
          location_status: "",
          city_id: "",
          trip_id: "",
          trip_point_id: "",
          location_type: "",
          location_date: "",
          location_time: "",
          counter_id: "",
          counter_name: "",
          counter_address: ""
        })
      };
    },
    methods: {
      editModal(boarding) {
        this.editMode = true;
        this.form.reset();
        $("#addModal").modal("show");
        this.form.fill(boarding);
      },
      newModal() {
        this.editMode = false;
        this.form.reset();
        $("#addModal").modal("show");
      },
      deleteBoarding(id) {
        swal
          .fire({
            title: "Are you sure?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          })
          .then(result => {
            if (result.value) {
              this.form
                .delete("api/boarding/" + id)
                .then(() => {
                  toast.fire({
                    type: "success",
                    title: "Boarding Deleted Successfully"
                  });
                  Fire.$emit("AfterAction");
                })
                .catch(() => {
                  swal.fire("", "Boarding Deleted Failed", "error");
                });
            }
          });
      },
      loadBoardings() {
        axios
          .get("api/boarding")
          .then(({ data }) => (this.boardings = data.data));
        axios.get("api/city").then(({ data }) => (this.cities = data.data));
      },
      updateBoarding() {
        this.$Progress.start();
        this.form
          .put("api/boarding/" + this.form.id)
          .then(() => {
            // success action
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "Boarding updated successfully"
            });
            this.$Progress.finish();
          })
          .catch(() => {
            // failed response
            swal.fire("", "Boarding Update Failed", "error");
            this.$Progress.fail();
          });
      },
      createBoarding() {
        this.$Progress.start();
        this.form
          .post("api/boarding")
          .then(() => {
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "boarding created successfully"
            });

            this.$Progress.finish();
          })
          .catch(() => {
            this.$Progress.fail();
          });
      }
    },
    created() {
      this.loadBoardings();
      Fire.$on("AfterAction", () => {
        this.loadBoardings();
      });
    }
  };
</script>
