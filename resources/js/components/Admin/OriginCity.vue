<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-indigo" style="background: #6574CD">
            <h3 class="card-title bg-indigo text-light">
              Origin City Table
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
                  <th>OriginCitySeq</th>
                  <th>Action</th>
                </tr>
                <tr v-for="origin_city in originCities" :key="origin_city.id">
                  <td>{{ origin_city.id }}</td>
                  <td>{{ origin_city.name | upText }}</td>
                  <td>{{ origin_city.origin_city_seq }}</td>
                  <td>
                    <a href="#" @click="editModal(origin_city)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a>
                    &nbsp;
                    <a href="#" @click="deleteOriginCity(origin_city.id)">
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
              Update Origin City
            </h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">
              Add new Origin City
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
            @submit.prevent="editMode ? updateOriginCity() : createOriginCity()"
          >
            <div class="modal-body">
              <div class="row">
                <div class="form-group col-md-6">
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
                    v-model="form.origin_city_seq"
                    type="number"
                    name="origin_city_seq"
                    placeholder="City Sequence"
                    class="form-control"
                  />
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
    {{ getData }}
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

          this.form.origin_city_seq = this.seqs[index];
        }
      }
    },
    components: {
      CoolSelect
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
    data() {
      return {
        editMode: false,
        originCities: {},
        cities: [],
        seqs: [],
        form: new Form({
          id: "",
          name: "",
          origin_city_seq: ""
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
      deleteOriginCity(id) {
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
                .delete("api/origincity/" + id)
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
      loadOriginCities() {
        axios
          .get("api/origincity")
          .then(({ data }) => (this.originCities = data.data));
      },
      updateOriginCity() {
        this.$Progress.start();
        this.form
          .put("api/origincity/" + this.form.id)
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
      createOriginCity() {
        this.$Progress.start();
        this.form
          .post("api/origincity")
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
      this.loadOriginCities();
      Fire.$on("AfterAction", () => {
        this.loadOriginCities();
      });
    }
  };
</script>
