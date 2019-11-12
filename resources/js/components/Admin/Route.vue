<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-indigo" style="background: #6574CD">
            <h3 class="card-title bg-indigo text-light">Route Table</h3>

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
                  <th>ID</th>
                  <th>OriginCityId</th>
                  <th>DestinationCityId</th>
                  <th>TripHeading</th>
                  <th>Action</th>
                </tr>
                <tr v-for="route in routes" :key="route.id">
                  <td>{{ route.id }}</td>
                  <td>{{ route.origin_city_id }}</td>
                  <td>{{ route.destination_city_id }}</td>
                  <td>{{ route.trip_heading }}</td>
                  <td>
                    <a href="#" @click="editModal(route)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a>
                    &nbsp;
                    <a href="#" @click="deleteRoute(route.id)">
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
              Update Route
            </h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">
              Add new Route
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

          <form @submit.prevent="editMode ? updateRoute() : createRoute()">
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-6">
                  <select
                    title="Origin City Required"
                    v-model="form.origin_city_id"
                    name="origin_city_id"
                    class="form-control form-control-sm"
                  >
                    <option value="">Select Origin City</option>
                    <option
                      v-for="city in origin_citys"
                      :key="city.id"
                      :value="city.id"
                      >{{ city.name }}</option
                    >
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <select
                    title="Destination City Required"
                    v-model="form.destination_city_id"
                    name="destination_city_id"
                    class="form-control form-control-sm"
                  >
                    <option value="">Select Destination City</option>
                    <option
                      v-for="des in destination_citys"
                      :key="des.id"
                      :value="des.id"
                      >{{ des.name }}</option
                    >
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <input
                    type="text"
                    v-model="form.trip_heading"
                    name="trip_heading"
                    class="form-control"
                  />
                  <has-error :form="form" field="description"></has-error>
                </div>
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
  export default {
    data() {
      return {
        editMode: false,
        routes: {},
        origin_citys: {},
        destination_citys: {},
        form: new Form({
          id: "",
          origin_city_id: "",
          destination_city_id: "",
          trip_heading: ""
        })
      };
    },
    mounted() {
      axios
        .get("api/origincity-list")
        .then(({ data }) => (this.origin_citys = data));
      axios
        .get("api/destinationcity-list")
        .then(({ data }) => (this.destination_citys = data));
    },
    methods: {
      editModal(city) {
        this.editMode = true;
        this.form.reset();
        $("#addModal").modal("show");
        this.form.fill(city);
      },
      newModal() {
        this.editMode = false;
        this.form.reset();
        $("#addModal").modal("show");
      },
      deleteRoute(id) {
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
                .delete("api/route/" + id)
                .then(() => {
                  toast.fire({
                    type: "success",
                    title: "Route Deleted Successfully"
                  });
                  Fire.$emit("AfterAction");
                })
                .catch(() => {
                  swal.fire("", "Route Deleted Failed", "error");
                });
            }
          });
      },
      loadRoutes() {
        axios.get("api/route").then(({ data }) => (this.routes = data.data));
      },
      updateRoute() {
        this.$Progress.start();
        this.form
          .put("api/route/" + this.form.id)
          .then(() => {
            // success action
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "Route updated successfully"
            });
            this.$Progress.finish();
          })
          .catch(() => {
            // failed response
            swal.fire("", "Route Update Failed", "error");
            this.$Progress.fail();
          });
      },
      createRoute() {
        this.$Progress.start();
        this.form
          .post("api/route")
          .then(() => {
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "Route created successfully"
            });

            this.$Progress.finish();
          })
          .catch(() => {
            this.$Progress.fail();
          });
      }
    },
    created() {
      this.loadRoutes();
      Fire.$on("AfterAction", () => {
        this.loadRoutes();
      });
    }
  };
</script>
