<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-indigo" style="background: #6574CD">
            <h3 class="card-title bg-indigo text-light">
              Destination City Table
            </h3>

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
                  <th>Name</th>
                  <th>DestinationCitySeq</th>
                  <th>Action</th>
                </tr>
                <tr v-for="descity in destinationcities" :key="descity.id">
                  <td>{{ descity.id }}</td>
                  <td>{{ descity.name | upText }}</td>
                  <td>{{ descity.destination_city_seq }}</td>
                  <td>
                    <a href="#" @click="editModal(descity)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a>
                    &nbsp;
                    <a href="#" @click="deleteDestinationCity(descity.id)">
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
              Update Destination City
            </h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">
              Add new Destination City
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
            @submit.prevent="
              editMode ? updateDestinationCity() : createDestinationCity()
            "
          >
            <div class="modal-body">
              <div class="form-group">
                <cool-select
                  :items="cities"
                  v-model="form.name"
                  id="origin_city"
                  name="name"
                  placeholder="Select Origin City"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.destination_city_seq"
                  type="number"
                  name="destination_city_seq"
                  placeholder="Destination City Name"
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
        if (this.form.name != null) {
          const index = this.cities.findIndex(city => city === this.form.name);

          this.form.destination_city_seq = this.seqs[index];
        }
      }
    },
    components: {
      CoolSelect
    },
    data() {
      return {
        editMode: false,
        destinationcities: {},
        cities: [],
        seqs: [],
        form: new Form({
          id: "",
          name: "",
          destination_city_seq: ""
        })
      };
    },
    mounted() {
      // load cities
      axios.get("api/city-list").then(({ data }) => {
        for (var i = 0; i < data.length; i++) {
          this.cities.push(data[i]["city_name"]);
          this.seqs.push(data[i]["sequence"]);
        }
      });
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
      deleteDestinationCity(id) {
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
                .delete("api/destinationcity/" + id)
                .then(() => {
                  toast.fire({
                    type: "success",
                    title: "City Deleted Successfully"
                  });
                  Fire.$emit("AfterAction");
                })
                .catch(() => {
                  swal.fire("", "City Deleted Failed", "error");
                });
            }
          });
      },
      loadDestinationCities() {
        axios
          .get("api/destinationcity")
          .then(({ data }) => (this.destinationcities = data.data));
      },
      updateDestinationCity() {
        this.$Progress.start();
        this.form
          .put("api/destinationcity/" + this.form.id)
          .then(() => {
            // success action
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "City updated successfully"
            });
            this.$Progress.finish();
          })
          .catch(() => {
            // failed response
            swal.fire("", "City Update Failed", "error");
            this.$Progress.fail();
          });
      },
      createDestinationCity() {
        this.$Progress.start();
        this.form
          .post("api/destinationcity")
          .then(() => {
            Fire.$emit("AfterAction");
            $("#addModal").modal("hide");
            toast.fire({
              type: "success",
              title: "City created successfully"
            });

            this.$Progress.finish();
          })
          .catch(() => {
            this.$Progress.fail();
          });
      }
    },
    created() {
      this.loadDestinationCities();
      Fire.$on("AfterAction", () => {
        this.loadDestinationCities();
      });
    }
  };
</script>
