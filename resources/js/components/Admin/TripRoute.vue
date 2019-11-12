<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="background: #4FC08D">
            <h3
              class="card-title text-light font-weight-bold"
              style="letter-spacing: 3px;"
            >Trip Route List</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-primary" @click="newModal">
                Add new
                <i class="fa fa-road">+</i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Company id</th>
                  <th>Company name</th>
                  <th>Origin city id</th>
                  <th>Destination city id</th>
                  <th>parent trip route id</th>
                  <th>business_class_fare</th>
                  <th>economy_class_fare</th>
                  <th>special_class_fare</th>
                  <th>Dep-date</th>
                  <th>Dep-time</th>
                  <th>Arr-date</th>
                  <th>Arr-time</th>
                  <th>Trip Number</th>
                  <th>Bus Type Id</th>
                  <th>Bus Desc</th>
                  <th style="min-width: 100px">Action</th>
                </tr>
                <tr v-for="trip_route in trip_routes.data" :key="trip_route.id">
                  <td>{{ trip_route.id }}</td>
                  <td>{{ trip_route.company_id }}</td>
                  <td>{{ trip_route.company_name }}</td>
                  <td>{{ trip_route.origin_city_id }}</td>
                  <td>{{ trip_route.destination_city_id }}</td>
                  <td>{{ trip_route.parent_trip_route_id }}</td>
                  <td>{{ trip_route.business_class_fare }}</td>
                  <td>{{ trip_route.economy_class_fare }}</td>
                  <td>{{ trip_route.special_class_fare }}</td>
                  <td>{{ trip_route.departure_date }}</td>
                  <td>{{ trip_route.departure_time }}</td>
                  <td>{{ trip_route.arrival_date }}</td>
                  <td>{{ trip_route.arrival_time }}</td>
                  <td>{{ trip_route.trip_number }}</td>
                  <td>{{ trip_route.bus_type_id }}</td>
                  <td>{{ trip_route.bus_desc }}</td>
                  <td>
                    <a href="#" @click="editModal(trip_route)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp;
                    <a href="#" @click="deleteTripRoute(trip_route.id)">
                      <i class="fas fa-trash red" style="font-size: 25px;"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="trip_routes" @pagination-change-page="getResults"></pagination>
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
            <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update Trip Route</h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add new Trip Route</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form
            @submit.prevent="editMode ? updateTripRoute() : createTripRoute()"
            enctype="multipart/form-data"
          >
            <!-- modal body -->
            <div class="modal-body" style="background: white">
              <div class="row">
                <div class="form-group col-md-6">
                  <input
                    v-model="form.company_id"
                    title="company id"
                    type="number"
                    name="company_id"
                    placeholder="Company id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('company_id') }"
                  />
                  <has-error :form="form" field="company_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                <cool-select
                :items="companies"
                id="company"
                v-model="form.company_name"
                type="text"
                name="company_name"
                placeholder="Select Company"
                :class="{ 'is-invalid': form.errors.has('company_name') }"
              />
                  <has-error :form="form" field="company_name"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <select
                    title="Origin City Required"
                    v-model="form.origin_city_id"
                    name="origin_city_id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('origin_city_id') }"
                  >
                    <option value="">Select Origin City</option>
                    <option
                      v-for="city in origin_citys"
                      :key="city.id"
                      :value="city.id"
                      >{{ city.name }}</option
                    >
                  </select>
                  <has-error :form="form" field="origin_city_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                   <select
                    title="Destination City Required"
                    v-model="form.destination_city_id"
                    name="destination_city_id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('destination_city_id') }"
                  >
                    <option value="">Select Destination City</option>
                    <option
                      v-for="des in destination_citys"
                      :key="des.id"
                      :value="des.id"
                      >{{ des.name }}</option
                    >
                  </select>
                  <has-error :form="form" field="destination_city_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.parent_trip_route_id"
                    title="parent trip Id"
                    type="text"
                    name="parent_trip_route_id"
                    placeholder="Parent trip route id"
                    value="0"
                    class="form-control form-control-sm"
                  />
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.business_class_fare"
                    title="business class fare"
                    type="number"
                    name="business_class_fare"
                    value="0.00"
                    step="0.01"
                    placeholder="Business class fare"
                    class="form-control form-control-sm"
                  />
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.economy_class_fare"
                    title="economy class fare"
                    type="number"
                    value="0.00"
                    step="0.01"
                    name="economy_class_fare"
                    placeholder="economy class fare"
                    class="form-control form-control-sm"
                  />
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.special_class_fare"
                    title="special class fare"
                    type="number"
                    value="0.00"
                    step="0.01"
                    name="special_class_fare"
                    placeholder="special class fare"
                    class="form-control form-control-sm"
                  />
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.departure_date"
                    title="Departure Date"
                    type="text"
                    name="departure_date"
                    placeholder="Departure Date"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('departure_date') }"
                  />
                  <has-error :form="form" field="departure_date"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.departure_time"
                    title="Departure Time"
                    type="text"
                    name="departure_time"
                    placeholder="Departure Time"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('departure_time') }"
                  />
                  <has-error :form="form" field="departure_time"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.arrival_date"
                    title="Arrival Date"
                    type="text"
                    name="arrival_date"
                    placeholder="Arrival Date"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('arrival_date') }"
                  />
                  <has-error :form="form" field="arrival_date"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.arrival_time"
                    title="Arrival Time"
                    type="text"
                    name="arrival_time"
                    placeholder="Arrival Time"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('arrival_time') }"
                  />
                  <has-error :form="form" field="arrival_time"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.trip_number"
                    title="Trip Number"
                    type="text"
                    name="trip_number"
                    placeholder="Trip Number"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('trip_number') }"
                  />
                  <has-error :form="form" field="trip_number"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.bus_type_id"
                    title="Bus type id"
                    type="text"
                    name="bus_type_id"
                    placeholder="Bus Type Id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('bus_type_id') }"
                  />
                  <has-error :form="form" field="bus_type_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.bus_desc"
                    title="Bus Description"
                    type="text"
                    name="bus_desc"
                    placeholder="Bus Description"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('bus_desc') }"
                  />
                  <has-error :form="form" field="bus_desc"></has-error>
                </div>
              </div>
            </div>
            <!-- END modal body -->
            {{getData}}
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
  // for autocomplete
import { CoolSelect } from "vue-cool-select";
    export default {
      computed: {
          getData() {
          if (this.form.company_name != null) {
            const index = this.companies.findIndex(
              company => company === this.form.company_name
              );
            this.form.company_id = this.companies_id[index];
          }
        }
      }
      ,
mounted() {
  axios.get('api/operator-list').then(({data}) => {
    for (var i = 0; i < data.length; i++) {
      this.companies.push(data[i]['company_name']);
      this.companies_id.push(data[i]['id']);
    }
  });
  axios
        .get("api/origincity-list")
        .then(({ data }) => (this.origin_citys = data));
      axios
        .get("api/destinationcity-list")
        .then(({ data }) => (this.destination_citys = data));
},
  components: {
    CoolSelect
  },
        data() {
          return {
            editMode: false,
            trip_routes: {},
            origin_citys: {},
            destination_citys: {},
            companies: [],
            companies_id: [],
            form: new Form({
              id: '',
              company_id: '',
              company_name: '',
              origin_city_id: '',
              destination_city_id: '',
              parent_trip_route_id: '',
              business_class_fare: '',
              economy_class_fare: '',
              special_class_fare: '',
              departure_date: '',
              departure_time: '',
              arrival_date: '',
              arrival_time: '',
              trip_number: '',
              bus_type_id: 2,
              bus_desc: '',
            })
          }
        },
        methods: {
          getResults(page = 1) {
          			axios.get('api/trip-route?page=' + page)
          				.then(response => {
          					this.trip_routes = response.data;
          				});
          		},
          editModal(trip_route) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(trip_route);
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteTripRoute(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/trip-route/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'Trip Route Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'Trip Route Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadTripRoutes() {
            axios.get("api/trip-route").then(({ data }) => (this.trip_routes = data));

          },
          updateTripRoute() {
            this.$Progress.start();
            this.form.put('api/trip-route/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'Trip Route updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'Trip Route Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createTripRoute() {
            this.$Progress.start();
            this.form.post('api/trip-route')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'Trip Route created successfully'
              })

              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadTripRoutes();
          Fire.$on('AfterAction', () => {
            this.loadTripRoutes();
          });
        }
      }
</script>
