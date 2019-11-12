<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-indigo" style="background: #6574CD">
            <h3 class="card-title bg-indigo text-light">Tickets Table</h3>

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
                  <th>TripID</th>
                  <th>CompanyID</th>
                  <th>Action</th>
                </tr>
                <tr v-for="ticket in Tickets" :key="ticket.id">
                  <td>{{ ticket.trip_id }}</td>
                  <td>{{ ticket.company_id }}</td>
                  <td>
                    <a href="#" @click="deleteTicket(ticket.id)">
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
              Update Ticket
            </h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">
              Add new Ticket
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

          <form @submit.prevent="editMode ? updateTickets() : createTicket()">
            <div class="modal-body">
              <div class="form-group">
                <select
                  title="trip info Required"
                  v-model="form.trip_id"
                  name="trip_id"
                  class="form-control form-control-sm"
                  :class="{ 'is-invalid': form.errors.has('trip_id') }"
                >
                  <option value="">Select Trip Info</option>
                  <option
                    v-for="trip in details"
                    :key="trip.id"
                    :value="trip.id"
                    >{{
                      "trip number: " +
                        trip.id +
                        "/company_name: " +
                        trip.company_name +
                        "/" +
                        trip.origin_city_name +
                        " to " +
                        trip.destination_city_name
                    }}</option
                  >
                </select>
              </div>
              <div class="form-group">
                <input
                  v-model="form.company_id"
                  type="number"
                  min="0"
                  name="company_id"
                  placeholder="company id"
                  class="form-control"
                />
              </div>
              <input
                type="hidden"
                name="available_seats"
                v-model="form.available_seats"
              />
            </div>
            {{ getData }}
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
    computed: {
      getData() {
        if (this.form.trip_id != null) {
          const index = this.trip_ids.findIndex(id => id === this.form.trip_id);
          this.form.company_id = this.company_ids[index];
          this.form.available_seats = this.seats[index];
        }
      }
    },
    mounted() {
      axios.get("api/detail-list").then(({ data }) => {
        for (var i = 0; i < data.length; i++) {
          this.trip_ids.push(data[i]["trip_id"]);
          this.company_ids.push(data[i]["company_id"]);
          this.seats.push(data[i]["available_seats"]);
        }
        return (this.details = data);
      });
    },
    data() {
      return {
        editMode: false,
        Tickets: {},
        trip_ids: [],
        company_ids: [],
        seats: [],
        details: {},
        form: new Form({
          trip_id: "",
          company_id: "",
          available_seats: ""
        })
      };
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
      deleteTicket(id) {
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
                .delete("api/ticket/" + id)
                .then(() => {
                  toast.fire({
                    type: "success",
                    title: "Ticket Deleted Successfully"
                  });
                  Fire.$emit("AfterAction");
                })
                .catch(() => {
                  swal.fire("", "City Deleted Failed", "error");
                });
            }
          });
      },
      loadTickets() {
        axios.get("api/ticket").then(({ data }) => (this.Tickets = data.data));
      },
      updateTickets() {
        this.$Progress.start();
        this.form
          .put("api/ticket/" + this.form.trip_id)
          .then(() => {
            // success action
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "Ticket updated successfully"
            });
            this.$Progress.finish();
          })
          .catch(() => {
            // failed response
            swal.fire("", "Ticket Update Failed", "error");
            this.$Progress.fail();
          });
      },
      createTicket() {
        this.$Progress.start();
        this.form
          .post("api/ticket")
          .then(() => {
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "Ticket created successfully"
            });

            this.$Progress.finish();
          })
          .catch(() => {
            this.$Progress.fail();
          });
      }
    },
    created() {
      this.loadTickets();
      Fire.$on("AfterAction", () => {
        this.loadTickets();
      });
    }
  };
</script>
