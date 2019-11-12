<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-indigo" style="background: #6574CD">
            <h3 class="card-title bg-indigo text-light">City Table</h3>

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
                  <th>Status</th>
                  <th>Sequence</th>
                  <th>ShortName</th>
                  <th>is_enroute</th>
                  <th>topcity</th>
                  <th>aboutCity</th>
                  <th>Action</th>
                </tr>
                <tr v-for="city in cities" :key="city.id">
                  <td>{{ city.id }}</td>
                  <td>{{ city.city_name | upText }}</td>
                  <td>{{ city.city_status }}</td>
                  <td>{{ city.sequence }}</td>
                  <td>{{ city.city_short_name }}</td>
                  <td>{{ city.is_enroute }}</td>
                  <td>{{ city.top_city }}</td>
                  <td>{{ city.about_city }}</td>
                  <td>
                    <a href="#" @click="editModal(city)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp;
                    <a href="#" @click="deleteCity(city.id)">
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
            <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update City</h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add new City</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form @submit.prevent="editMode ? updateCity() : createCity()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.city_name"
                  type="text"
                  name="city_name"
                  placeholder="City Name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('city_name') }"
                />
                <has-error :form="form" field="city_name"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="form.city_status"
                  type="text"
                  name="city_status"
                  placeholder="City Status"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <input
                  v-model="form.sequence"
                  type="number"
                  min="0"
                  name="sequence"
                  placeholder="Sequence"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <input
                  v-model="form.city_short_name"
                  type="text"
                  name="city_short_name"
                  placeholder="city short Name"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <input
                  v-model="form.is_enroute"
                  type="number"
                  min="0"
                  name="is_enroute"
                  placeholder="is enroute"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <input
                  v-model="form.top_city"
                  type="number"
                  min="0"
                  name="top_city"
                  placeholder="Top city"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <input
                  v-model="form.about_city"
                  type="text"
                  name="about_city"
                  placeholder="About City"
                  class="form-control"
                />
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
              <button v-show="editMode" type="submit" class="btn btn-success btn-sm">Update</button>
              <button v-show="!editMode" type="submit" class="btn btn-primary btn-sm">Create</button>
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
            cities: {},
            form: new Form({
              id: '',
              city_name: '',
              city_status: '',
              sequence: '',
              city_short_name: '',
              is_enroute: '',
              top_city: '',
              about_city: '',
            })
          }
        },
        methods: {
          editModal(city) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(city);
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteCity(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/city/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'City Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'City Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadCities() {
            axios.get("api/city").then(({ data }) => (this.cities = data.data));
          },
          updateCities() {
            this.$Progress.start();
            this.form.put('api/city/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'City updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'City Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createCity() {
            this.$Progress.start();
            this.form.post('api/city')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'City created successfully'
              })

              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadCities();
          Fire.$on('AfterAction', () => {
            this.loadCities();
          });
        }
      }
</script>
