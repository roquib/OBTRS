<template>
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header" style="background: #563D7C">
              <h3 class="card-title text-light">Books Table

              </h3>



              <div class="card-tools">
                <table>
                  <tr>
                    <td>
                      <!-- Product Search -->
                      <div class="input-group float-right">
                        <input type="text" @keyup="search_product" v-model="prduct_search" class="form-control text-light" style="background: #563D7C" placeholder="Search Product">
                        <div class="input-group-append">
                          <span class="btn btn-outline-light">Search</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <button type="button" class="ml-3 btn btn-outline-warning" @click="newModal">Add Product</i> </button>

                    </td>
                  </tr>
                </table>


              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody>
                  <tr class="bg-primary">
                  <th>ID</th>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Group</th>
                  <th>Author</th>
                  <th>Price</th>
                  <th>Offer</th>
                  <th>Action</th>
                </tr>
                <tr v-for="product in products.data" :key="product.id">
                  <td> {{ product.id }} </td>
                  <td> {{ product.name | upText }} </td>
                  <td> <img :src="'product/'+product.image" alt="No image" style="height: 80px; width: 80px;"> </td>
                  <!-- <td> {{ product.catName }} </td> -->
                  <td> {{ product.group.name }} </td>
                  <td> {{ product.author.name }} </td>
                  <td> {{ product.price }} Tk.</td>
                  <td> {{ product.offer }}%</td>
                  <td>
                    <a href="#" @click="editModal(product)">
                      <i class="fas fa-edit green" style="font-size: 25px;"></i>
                    </a> &nbsp;
                    <a href="#" @click="deleteProduct(product.id)">
                      <i class="fas fa-trash red" style="font-size: 25px;"></i>
                    </a>
                  </td>
                </tr>

              </tbody></table>
            </div>
            <div class="card-footer">
              <pagination :data="products" @pagination-change-page="getResults"></pagination>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>





      <!-- Modal -->
      <div style="z-index: 30000" class="modal fade" id="addModal" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content" style="background: #563D7C">

            <!-- MODAL HEADER -->
            <div class="modal-header text-light">
              <h5 v-show="editMode" class="modal-title" id="exampleModalLabel">Update Product</h5>
              <h5 v-show="!editMode" class="modal-title" id="exampleModalLabel">Add New Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="text-light" aria-hidden="true">&times;</span>
              </button>
            </div>
            <!-- END MODAL HEADER -->



            <form @submit.prevent="editMode ? updateProduct() : createProduct()">

              <!-- modal body -->
              <div class="modal-body" style="background: white">
                <div class="row">
                  <div class="form-group col-md-6">
                    <input v-model="form.name" title="Name Required" type="text" name="name" placeholder="Product Name"
                      class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                  </div>

                  <div class="form-group col-md-6">
                    <select title="Group Not Required" v-model="form.group_id" name="type" class="form-control form-control-sm" >
                      <option value="">Select Group</option>
                      <option v-for="group in groups" :key="group.id" :value="group.id">{{ group.name }}</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <select title="Category Required" v-model="form.category_id" name="type" class="form-control form-control-sm"  :class="{ 'is-invalid': form.errors.has('category_id') }">
                      <option value="">Select Category</option>
                      <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                  </div>

                  <div class="form-group col-md-6">
                    <input title="Price Required" v-model="form.price" type="number" name="price" placeholder="Sale Price"
                      class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('price') }">
                    <has-error :form="form" field="price"></has-error>
                  </div>

                  <div class="form-group col-md-6">
                    <input title="Quantity Required" v-model="form.qty" type="number" name="qty" placeholder="Quantity"
                      class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('qty') }">
                    <has-error :form="form" field="qty"></has-error>
                  </div>

                  <div class="form-group col-md-6">
                    <input title="Discount/Offer Price Not Required" v-model="form.offer" type="number" name="offer" placeholder="Ofer Price(%)" class="form-control form-control-sm" >
                  </div>

                  <div class="form-group col-md-6">
                    <input title="ISBN Number Not Required" v-model="form.isbn_no" type="text" name="isbn_no" placeholder="ISBN Number" class="form-control form-control-sm" >
                  </div>

                  <div class="form-group col-md-6">
                    <select title="Author Required" v-model="form.author_id" name="type" class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('author_id') }">
                      <option value="">Author/Writer</option>
                      <option v-for="author in authors" :key="author.id" :value="author.id">{{ author.name }}</option>
                    </select>
                    <has-error :form="form" field="author_id"></has-error>
                  </div>

                  <div class="form-group col-md-6">
                    <select title="Publication Not Required" v-model="form.publication_id" name="type" class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('publication_id') }">
                      <option value="">Publication</option>
                      <option v-for="publication in publications" :key="publication.id" :value="publication.id">{{ publication.name }}</option>
                    </select>
                    <has-error :form="form" field="publication_id"></has-error>
                  </div>

                  <div class="form-group col-md-6">
                    <select title="Status Required" v-model="form.publication_status" name="type" class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('publication_status') }">
                      <option value="">Status</option>
                      <option value="1">Active</option>
                      <option value="0">Deactive</option>
                    </select>
                    <has-error :form="form" field="publication_status"></has-error>
                  </div>

                  <div class="form-group col-md-6">
                    <textarea title="Description Required" v-model="form.description" placeholder="Short Description" name="description" rows="3" cols="80"
                      class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                    /
                  </div>

                  <div class="col-md-6">
                    <input class="mb-2"  type="file" name="image" @change="uploadImage">
                    <img :src="showImage" alt="No image" style="height: 80px; width: 80px; border: 2px solid gray">
                  </div>

                </div>
              </div>
              <!-- END modal body -->

              <!-- modal footer -->
              <div class="modal-footer bg-light">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                <button v-show="editMode" type="submit" class="btn btn-success btn-sm">Update</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary btn-sm">Create</button>
              </div>
              <!-- END modal footer -->

            </form>
          </div>
        </div>
      </div> <!-- End modal -->






    </div>
</template>



<script>
    export default {
        data() {
          return {
            editMode: false,
            products: {},
            groups: {},
            categories: {},
            authors: {},
            publications: {},
            showImage: '',
            prduct_search: '',
            form: new Form({
              id: '',
              name: '',
              group_id: '',
              category_id: '',
              price: '',
              offer: '',
              qty: 1,
              isbn_no: '',
              author_id: '',
              publication_id: '',
              publication_status: '',
              description: '',
              image: '',
            })
          }
        },
        methods: {
          getResults(page = 1) {
          		axios.get('api/product?page=' + page)
              .then(response => {
          		this.products = response.data;
          	});
          },
          uploadImage(e) {
            // console.log('uploading');
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onloadend = (file) => {
              this.form.image = reader.result;
              this.showImage = reader.result;
            }
            reader.readAsDataURL(file);
          },
          editModal(product) {
            this.editMode = true;
            this.form.reset();
            $("#addModal").modal('show');
            this.form.fill(product);
            this.showImage = "product/" + this.form.image;
          },
          newModal() {
            this.editMode = false;
            this.form.reset();
            $("#addModal").modal('show');
          },
          deleteProduct(id) {
            swal.fire({
              title: 'Are you sure?',
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
              if (result.value) {
                this.form.delete('api/product/'+id).then(()=>{
                  toast.fire({
                    type: 'success',
                    title: 'Product Deleted Successfully'
                  });
                  Fire.$emit('AfterAction');
                }).catch(()=>{
                  swal.fire(
                    '',
                    'Product Deleted Failed',
                    'error'
                  )
                })

              }
            })
          },
          loadProducts() {
            axios.get("api/product").then(({ data }) => (this.products = data));
            axios.get("api/group").then(({ data }) => (this.groups = data.data));
            axios.get("api/category-list").then(({ data }) => (this.categories = data.data));
            axios.get("api/author-list").then(({ data }) => (this.authors = data.data));
            axios.get("api/publication").then(({ data }) => (this.publications = data.data));
          },
          search_product() {
            // alert(this.prduct_search);
            if (this.prduct_search != "") {
            axios.get("api/product/search/"+this.prduct_search)

            .then(({ data }) => (this.products = data));
          }
          },
          updateProduct() {
            this.$Progress.start();
            this.form.put('api/product/' + this.form.id)
            .then(()=>{
                // success action
                Fire.$emit('AfterAction');
                $("#addModal").modal('hide');
                toast.fire({
                  type: 'success',
                  title: 'Product updated successfully'
                })
                this.$Progress.finish();
            }).catch(()=>{
              // failed response
              swal.fire(
                '',
                'Product Update Failed',
                'error'
              )
              this.$Progress.fail();
            });
          },
          createProduct() {
            this.$Progress.start();
            this.form.post('api/product')
            .then(()=> {
              Fire.$emit('AfterAction');
              $("#addModal").modal('hide');
              toast.fire({
                type: 'success',
                title: 'Product created successfully'
              }).catch((err) => {
                    console.log(err)
                });

              this.$Progress.finish();
              this.showImage = '';
            })
            .catch(()=>{
              this.$Progress.fail();
            })

          }
        },
        created() {
          this.loadProducts();
          Fire.$on('AfterAction', () => {
            this.loadProducts();
          });
        }
      }
</script>
