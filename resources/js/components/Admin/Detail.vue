<template>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header" style="background: #4FC08D">
            <h3
              class="card-title text-light font-weight-bold"
              style="letter-spacing: 3px;"
            >Detail List</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-primary" @click="newModal">
                Add new
                <i class="fas fa-info-circle">+</i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th>ID</th>
                  <th>Trip id</th>
                  <th>Company name</th>
                  <th>Image</th>
                  <th>Origin city</th>
                  <th>Destination city</th>
                  <th>Price</th>
                  <th>Dep-date</th>
                  <th>Dep-time</th>
                  <th>Arr-date</th>
                  <th>Arr-time</th>
                  <th>Available</th>
                  <th>Bus type</th>
                  <th>Trip Number</th>
                  <th>Trip Heading</th>
                  <th>Bus Desc</th>
                  <th>ava_seats</th>
                  <th>trip date</th>
                  <th>trip time</th>
                  <th style="min-width: 100px">Action</th>
                </tr>
                <tr v-for="detail in details.data" :key="detail.id">
                  <td>{{ detail.id }}</td>
                  <td>{{ detail.trip_id }}</td>
                  <td>{{ detail.company_name }}</td>
                  <td><img :src="'img/writer/'+detail.image" style="width: 100%" alt="no image"></td>
                  <td>{{ detail.origin_city_name }}</td>
                  <td>{{ detail.destination_city_name }}</td>
                  <td>{{ detail.economy_class_fare }}</td>
                  <td>{{ detail.departure_date }}</td>
                  <td>{{ detail.departure_time }}</td>
                  <td>{{ detail.arrival_date }}</td>
                  <td>{{ detail.arrival_time }}</td>
                  <td>{{ detail.available_till_datetime }}</td>
                  <td>{{ detail.bus_type_id }}</td>
                  <td>{{ detail.trip_number }}</td>
                  <td>{{ detail.trip_heading }}</td>
                  <td>{{ detail.bus_desc }}</td>
                  <td>{{ detail.available_seats }}</td>
                  <td>{{ detail.trip_origin_date }}</td>
                  <td>{{ detail.trip_origin_time }}</td>
                  <td>
                    <a href="#" @click="editModal(detail)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp;
                    <a href="#" @click="deleteDetail(detail.id)">
                      <i class="fas fa-trash red" style="font-size: 25px;"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            <pagination :data="details" @pagination-change-page="getResults"></pagination>
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
            <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update Detail</h5>
            <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add new Detail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form
            @submit.prevent="editMode ? updateDetail() : createDetail()"
            enctype="multipart/form-data"
          >
            <!-- modal body -->
            <div class="modal-body" style="background: white">
              <div class="row">
                <div class="form-group col-md-6">
                  <input
                    v-model="form.trip_id"
                    title="Trip Id Required"
                    type="number"
                    name="trip_id"
                    placeholder="Trip id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('trip_id') }"
                  />
                  <has-error :form="form" field="trip_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.trip_route_id"
                    title="Trip Route id Required"
                    type="number"
                    name="trip_route_id"
                    placeholder="Trip Route id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('trip_route_id') }"
                  />
                  <has-error :form="form" field="trip_route_id"></has-error>
                </div>
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
                placeholder="company name"
                :class="{ 'is-invalid': form.errors.has('company_name') }"
              />
                  <has-error :form="form" field="company_name"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.origin_city_id"
                    title="Origin City Id"
                    type="number"
                    name="origin_city_id"
                    placeholder="Origin City Id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('origin_city_id') }"
                  />
                  <has-error :form="form" field="origin_city_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.origin_city_name"
                    title="Origin City Id"
                    type="text"
                    name="origin_city_name"
                    placeholder="Origin City Name"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('origin_city_name') }"
                  />
                  <has-error :form="form" field="origin_city_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.destination_city_id"
                    title="Destination City Id"
                    type="number"
                    name="destination_city_id"
                    placeholder="Destination City id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('destination_city_id') }"
                  />
                  <has-error :form="form" field="destination_city_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.destination_city_name"
                    title="Destination City Id"
                    type="text"
                    name="destination_city_name"
                    placeholder="Destination City Name"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('destination_city_name') }"
                  />
                  <has-error :form="form" field="destination_city_name"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.parent_trip_route_id"
                    title="parent trip Id"
                    type="number"
                    name="parent_trip_route_id"
                    placeholder="Parent trip id"
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
                    v-model="form.available_till_datetime"
                    title="available till datetime"
                    type="text"
                    name="available_till_datetime"
                    placeholder="available till datetime"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('available_till_datetime') }"
                  />
                  <has-error :form="form" field="available_till_datetime"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.bus_type_id"
                    title="Bus type id"
                    type="number"
                    name="bus_type_id"
                    value="2"
                    placeholder="Bus Type id"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('bus_type_id') }"
                  />
                  <has-error :form="form" field="bus_type_id"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <cool-select
                :items="trip_numbers"
                id="company"
                v-model="form.trip_number"
                type="text"
                name="trip_number"
                placeholder="select trip number"
                :class="{ 'is-invalid': form.errors.has('trip_number') }"
              />
                  <has-error :form="form" field="trip_number"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <cool-select
                :items="trip_headings"
                id="trip_heading"
              
                v-model="form.trip_heading"
                type="text"
                name="trip_heading"
                placeholder="select trip heading"
                :class="{ 'is-invalid': form.errors.has('trip_heading') }"
              />
                  <has-error :form="form" field="trip_heading"></has-error>
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
                <div class="form-group col-md-6">
                  <input
                    v-model="form.available_seats"
                    title="Available Seats"
                    type="text"
                    name="available_seats"
                    value="40"
                    placeholder="Available Seats"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('available_seats') }"
                  />
                  <has-error :form="form" field="available_seats"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.trip_origin_date"
                    title="Trip origin date"
                    type="text"
                    name="trip_origin_date"
                    placeholder="Trip origin Date"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('trip_origin_date') }"
                  />
                  <has-error :form="form" field="trip_origin_date"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <input
                    v-model="form.trip_origin_time"
                    title="Trip origin Time"
                    type="text"
                    name="trip_origin_time"
                    placeholder="Trip origin Time"
                    class="form-control form-control-sm"
                    :class="{ 'is-invalid': form.errors.has('trip_origin_time') }"
                  />
                  <has-error :form="form" field="trip_origin_time"></has-error>
                </div>
                <div class="col-md-6">
                  <input class="mb-2" type="file" name="image" @change="uploadImage" />
                  <img
                    :src="showImage"
                    alt="No image"
                    style="height: 80px; width: 80px; border: 2px solid gray"
                  />
                </div>
              </div>
            </div>
            <!-- END modal body -->
            
            <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
              <button v-show="editMode" type="submit" class="btn btn-success btn-sm">Update</button>
              <button v-show="!editMode" type="submit" class="btn btn-primary btn-sm">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{getData}}
    <!-- End modal -->
  </div>
</template>



<script>
  // for autocomplete
import { CoolSelect } from "vue-cool-select";
    export default {
      computed: {
          getData() {
          if (this.form.trip_number != null) {
            const index = this.trip_numbers.findIndex(
              n => n === this.form.trip_number
            );
            this.form.company_id = this.company_ids[index];
            this.form.trip_id = this.last_trip_ids[0]+1;
            this.form.company_name = this.company_names[index];
            this.form.origin_city_id = this.origin_city_ids[index];
            this.form.destination_city_id = this.destination_city_ids[index];
            this.form.parent_trip_route_id = this.parent_trip_route_ids[index];
            this.form.business_class_fare = this.business_class_fares[index];
            this.form.economy_class_fare = this.economy_class_fares[index];
            this.form.special_class_fare = this.special_class_fares[index];
            this.form.departure_date = this.departure_dates[index];
            this.form.departure_time = this.departure_times[index];
            this.form.arrival_date = this.arrival_dates[index];
            this.form.arrival_time = this.arrival_times[index];
            this.form.available_till_datetime = this.departure_dates[index] + " " + this.departure_times[index];;
            this.form.bus_desc = this.bus_descs[index];
            this.form.bus_type_id = this.bus_type_ids[index];
            this.form.trip_route_id = this.trip_route_ids[index];
            const origin_id = this.trip_origin_city_ids.findIndex(
              city_id => city_id === this.form.origin_city_id
            );
            const destination_id = this.trip_destination_city_ids.findIndex(
              dest_id => dest_id === this.form.destination_city_id
            );
            this.origin_id = origin_id;
            this.destination_id = destination_id;
            this.form.origin_city_name = this.origin_city_names[origin_id];
            this.form.destination_city_name = this.destination_city_names[destination_id];
            this.form.trip_origin_date = this.departure_dates[index];
            this.form.trip_origin_time = this.departure_times[index];
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
  axios.get('api/trip-route-list').then(({data}) => {
    for (var i = 0; i < data.length; i++) {
      this.trip_route_ids.push(data[i]['id']);
      this.trip_numbers.push(data[i]['trip_number']);
      this.company_ids.push(data[i]['company_id']);
      this.company_names.push(data[i]['company_name']);
      this.origin_city_ids.push(data[i]['origin_city_id']);
      this.destination_city_ids.push(data[i]['destination_city_id']);
      this.parent_trip_route_ids.push(data[i]['parent_trip_route_id']);
      this.business_class_fares.push(data[i]['business_class_fare']);
      this.economy_class_fares.push(data[i]['economy_class_fare']);
      this.special_class_fares.push(data[i]['special_class_fare']);
      this.departure_dates.push(data[i]['departure_date']);
      this.departure_times.push(data[i]['departure_time']);
      this.arrival_dates.push(data[i]['arrival_date']);
      this.arrival_times.push(data[i]['arrival_time']);
      this.bus_descs.push(data[i]['bus_desc']);
      this.bus_type_ids.push(data[i]['bus_type_id']);
    }
  });
  axios.get('api/route-list').then(({data}) => {
    for (var i = 0; i < data.length; i++) {
      this.trip_headings.push(data[i]['trip_heading']);
      this.trip_origin_city_ids.push(data[i]['origin_city_id']);
      this.trip_destination_city_ids.push(data[i]['destination_city_id']);
    }
  });
  axios
        .get("api/origincity-list")
        .then(({data}) => {
    for (var i = 0; i < data.length; i++) {
      this.origin_city_names.push(data[i]['name']);
    }
  });
      axios
        .get("api/destinationcity-list")
        .then(({data}) => {
    for (var i = 0; i < data.length; i++) {
      this.destination_city_names.push(data[i]['name']);
    }
  });
      axios
        .get("api/last-trip-id")
        .then(({data}) => {
    for (var i = 0; i < data.length; i++) {
      this.last_trip_ids.push(data[i]['id']);
    }
  });
},
  components: {
    CoolSelect
  },
        data() {
          return {
            editMode: false,
            details: {},
            origin_city_names: [],
            destination_city_names: [],
            showImage:'',
            companies: [],
            last_trip_ids: [],
            trip_numbers: [],
            trip_origin_city_ids: [],
            trip_destination_city_ids: [],
            company_ids: [],
            company_names: [],
            origin_id: '',
            destination_id: '',
            trip_route_ids: [],
            bus_type_ids: [],
            origin_city_ids: [],
            destination_city_ids: [],
            parent_trip_route_ids: [],
            business_class_fares: [],
            economy_class_fares: [],
            special_class_fares: [],
            departure_dates: [],
            departure_times: [],
            arrival_dates: [],
            arrival_times: [],
            bus_descs: [],
            trip_headings: [],
            companies_id: [],
            selectedCompany: '',
            select_company_id: 0,
            form: new Form({
              id: '',
              trip_id: '',
              trip_route_id: '',
              company_id: '',
              company_name: '',
              image: '',
              origin_city_id: '',
              origin_city_name: '',
              destination_city_id: '',
              destination_city_name: '',
              parent_trip_route_id: '',
              business_class_fare: '',
              economy_class_fare: '',
              special_class_fare: '',
              departure_date: '',
              departure_time: '',
              arrival_date: '',
              arrival_time: '',
              available_till_datetime: '',
              bus_type_id: '',
              trip_number: '',
              trip_heading: '',
              bus_desc: '',
              available_seats: '',
              trip_origin_date: '',
              trip_origin_time: '',
            })
          }
        },
        methods: {
          
          getResults(page = 1) {
          			axios.get('api/detail?page=' + page)
          				.then(response => {
          					this.details = response.data;
          				});
          		},
          uploadImage(e) {
            // console.log('uploading');
            let file = e.target.files[0];
            // console.log(file);
            console.log('Image size is: ' + file['size']);
            let reader = new FileReader();
            reader.onloadend = (file) => {
              this.form.image = reader.result;
              this.showImage = reader.result;
            }
            reader.readAsDataURL(file);
          },
          editModal(author) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(author);
            this.showImage = "img/writer/" + this.form.image;
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteDetail(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/detail/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'Detail Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'Detail Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadDetails() {
            axios.get("api/detail").then(({ data }) => (this.details = data));

          },
          updateDetail() {
            this.$Progress.start();
            this.form.put('api/detail/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'Detail updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'Detail Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createDetail() {
            this.$Progress.start();
            this.form.post('api/detail')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'Detail created successfully'
              })

              this.$Progress.finish();
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadDetails();
          Fire.$on('AfterAction', () => {
            this.loadDetails();
          });
        }
      }
</script>
