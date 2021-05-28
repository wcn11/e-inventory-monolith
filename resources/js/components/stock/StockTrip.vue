<template>

    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Tetapkan Tanggal Pengiriman:</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="container">
                            <div class="large-12 medium-12 small-12 cell">
                                <div class="form-group">
                                    <label for="file"> Tambahkan File Berupa Tipe Ms. Excel. Contoh: .xls, .xlsx, csv, spreadsheet, dll</label>
                                    <input type="file" id="file" name="file" class="form-control form-control-border" :class="{'is-invalid': errors[0]}" ref="file" v-on:change="handleFileUpload()" @change="checkFile($event)" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" pattern="^.+\.(xlsx|xls|csv)$" required/>
                                    <div class="invalid-feedback text-center" v-if="errors.length > 0">
                                        {{ errors[0].message}}
                                    </div>
                                </div>
                                <br>
                                <div class="justify-content-center">
                                    <span class="badge badge-info position-relative" :style="`left: ${uploadPercentage ? uploadPercentage - 4 : 0}% `"> {{ uploadPercentage }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped" :class="{'progress-bar-animated': uploadPercentage < 100}" role="progressbar" max="100" :value.prop="uploadPercentage" aria-valuemin="0" aria-valuemax="100" :style="`width: ${uploadPercentage}%`"></div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="schedule">jadwalkan Pengiriman:</label>
                            <h3> {{ today }}</h3>
<!--                            <input type="date" name="schedule" id="schedule" :class="{'is-invalid': scheduleError[0]}"  v-model="schedule" class="form-control" required>-->
<!--                            <div class="invalid-feedback text-center" v-if="scheduleError.length > 0">-->
<!--                                {{ scheduleError[0].message}}-->
<!--                            </div>-->
                        </div>
                        <button class="btn btn-success float-right" @click="upload"><i class="fas fa-upload"></i> Upload File</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->



        <div class="modal fade" id="modal-upload">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-warning">
                    <div class="modal-header justify-content-around">
                        <h4 class="modal-title text-center"><i class="fas fa-exclamation-triangle"></i> PERINGATAN <i class="fas fa-exclamation-triangle"></i></h4>
                    </div>
                    <div class="modal-body">
                        <h5>Data yang diupload tidak dapat dikembalikan kembali, Pastikan File Benar!</h5>
                        <small>Catatan: Pastikan File Yang Diupload Sudah Benar</small>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-dark" data-dismiss="modal"><i class="fad fa-times-octagon"></i> Batalkan</button>
                        <button type="button" class="btn btn-outline-dark" @click="submitFile"><i class="fas fa-cloud-upload-alt"></i> Upload Sekarang</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
import jquery from 'jquery'
import moment from 'moment'

moment.locale('id');

export default {
    name: "StockTrip",
    data(){
        return {
            file: '',
            uploadPercentage: 0,
            errors: [],
            // schedule: Date,
            scheduleError: [],
            today: Date
        }
    },
    methods: {
        handleFileUpload(){
            this.file = this.$refs.file.files[0];
        },
        upload(){

            if (!this.file){
                this.errors = [{
                    error: true,
                    message: 'Harap Tambahkan File!'
                }]

                this.closeModal()

                return
            }

            if (!this.schedule instanceof Date){
                this.scheduleError = [{
                    error: true,
                    message: 'Harap Tambahkan Tanggal!'
                }]

                this.closeModal()

                return
            }

            jquery("#modal-upload").modal('show')

        },
        submitFile(){
            /*
              Initialize the form data
            */
            let formData = new FormData();

            /*
              Add the form data we need to submit
            */
            formData.append('file', this.file);

            /*
              Make the request to the POST /single-file URL
            */
            axios.post( '/api/stock/upload',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function( progressEvent ) {
                        this.uploadPercentage = Math.round( ( progressEvent.loaded / progressEvent.total ) * 100 );
                    }.bind(this)
                }
            ).then(function(){
                console.log('SUCCESS!!');
                if (this.uploadPercentage >= 100){

                }
            })
                .catch(function(){
                    console.log('FAILURE!!');
                });
        },
        checkFile(e){
            console.log(e)
        },
        closeModal(){
            this.file = ''
            this.uploadPercentage = 0
            this.errors = []
        },
        setToday(){
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();
            let hour = today.getHours()
            let minute = today.getMinutes()


            today = mm + '/' + dd + '/' + yyyy + ' ' + hour + ':' + minute;
            this.today = moment(today).format('DD MMMM yyyy, HH:mm');
        }
    },
    mounted(){
        this.setToday()
    }
}
</script>

<style scoped>
    #file{
        cursor: pointer;
    }
</style>
