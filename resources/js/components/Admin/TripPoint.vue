<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-indigo" style="background: #6574CD">
            <h3 class="card-title bg-indigo text-light">Trip Point Table</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-success" @click="newModal">
                Add new <i class="fas fa-user-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Action</th>
                </tr>
                <tr v-for="trip_point in tripPoints" :key="trip_point.id">
                  <td>{{ trip_point.id }}</td>
                  <td>{{ trip_point.location_name | capitalize }}</td>
                  <td>{{ trip_point.location_status }}</td>
                  <td>{{ trip_point.location_type }}</td>
                  <td>{{ trip_point.created_at.split(" ")[0] }}</td>
                  <td>{{ trip_point.created_at.split(" ")[1] }}</td>
                  <td>
                    <a href="#" @click="editModal(trip_point)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a>
                    &nbsp;
                    <a href="#" @click="deleteTripPoint(trip_point.id)">
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
              Update Trip Point
            </h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">
              Add new Trip Point
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
            @submit.prevent="editMode ? updateTripPoint() : createTripPoint()"
          >
            <div class="modal-body">
              <div class="form-group mb-2">
                <input
                  v-model="form.location_name"
                  type="text"
                  name="location_name"
                  placeholder="Location Name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('location_name') }"
                />
                <has-error :form="form" field="location_name"></has-error>
              </div>
              <div class="form-group mb-2">
                <input
                  v-model="form.location_status"
                  type="number"
                  min="1"
                  name="location_status"
                  placeholder="Location Status"
                  class="form-control"
                />
              </div>
              <div class="form-group mb-2">
                <input
                  v-model="form.location_type"
                  type="text"
                  name="location_type"
                  placeholder="Location Type"
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
  export default {
    data() {
      return {
        editMode: false,
        tripPoints: {},
        form: new Form({
          id: "",
          location_name: "",
          location_status: "",
          location_type: ""
        })
      };
    },
    methods: {
      editModal(tripPoint) {
        this.editMode = true;
        this.form.reset();
        $("#addModal").modal("show");
        this.form.fill(tripPoint);
      },
      newModal() {
        this.editMode = false;
        this.form.reset();
        $("#addModal").modal("show");
      },
      deleteTripPoint(id) {
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
                .delete("api/trip-point/" + id)
                .then(() => {
                  toast.fire({
                    type: "success",
                    title: "Trip Point Deleted Successfully"
                  });
                  Fire.$emit("AfterAction");
                })
                .catch(() => {
                  swal.fire("", "Trip Point Deleted Failed", "error");
                });
            }
          });
      },
      loadTripPoints() {
        axios
          .get("api/trip-point")
          .then(({ data }) => (this.tripPoints = data.data));
      },
      updateTripPoint() {
        this.$Progress.start();
        this.form
          .put("api/trip-point/" + this.form.id)
          .then(() => {
            // success action
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "Trip Point updated successfully"
            });
            this.$Progress.finish();
          })
          .catch(() => {
            // failed response
            swal.fire("", "Trip Point Update Failed", "error");
            this.$Progress.fail();
          });
      },
      createTripPoint() {
        this.$Progress.start();
        this.form
          .post("api/trip-point")
          .then(() => {
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "Trip point created successfully"
            });

            this.$Progress.finish();
          })
          .catch(() => {
            this.$Progress.fail();
          });
      }
    },
    created() {
      this.loadTripPoints();
      Fire.$on("AfterAction", () => {
        this.loadTripPoints();
      });
    }
  };
</script>
