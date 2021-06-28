<template>

    <div class="form">
        <div class="form-group">
            <label for="name">Nama Peran</label>
            <input type="text" name="name" v-model="name" class="form-control" id="name" aria-describedby="emailHelp">
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="descriptions" v-model="descriptions" class="form-control" id="description"></textarea>
        </div>
        <div class="form-group">
            <permission @setPermission="setPermission"></permission>
        </div>
        <div class="form-group justify-content-end">
            <button class="btn btn-default text-right" @click="createRoles"><i class="fad fa-plus-circle"></i> Buatkan Peran</button>
        </div>
    </div>
</template>

<script>
import permission from './Permission/Permission'

export default {
    name: "Roles",
    components: {
        permission,
    },
    data(){
      return {
          permissions: [],
          name: "",
          descriptions: "",
      }
    },
    methods: {
        setPermission(permissions){

            this.permissions = permissions

        },
        createRoles(){
            axios.post("/api/roles/create", {
                "name": this.name,
                "descriptions": this.descriptions,
                "permissions": this.permissions
            }).then(res => {

                if (res.data.success){
                    this.$toastr.s("Peran Dibuat!", "Berhasil");
                    history.go(-1)
                }

            }).catch(err => {

                if (typeof err.response.data.message === 'object'){

                    const length = Object.keys(err.response.data.message).length

                    if (length >= 1){
                        for(let i = 0; i < length; i++){
                            let key = Object.keys(err.response.data.message)[i];
                            this.$toastr.e(err.response.data.message[key] , "Error");
                        }
                        return
                    }
                }

                this.$toastr.e(err.response.data.message , "Error");
            })
        }
    }
}
</script>

<style scoped>

</style>
