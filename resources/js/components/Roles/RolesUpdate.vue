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
            <permission @setPermission="setPermission" :access="access"></permission>
        </div>
        <div class="form-group justify-content-end">
            <button class="btn btn-default text-right" @click="updateRoles"><i class="fad fa-edit"></i> Update Peran</button>
        </div>
    </div>
</template>

<script>
import permission from './Permission/Permission'

export default {
    name: "RolesUpdate",
    props: ['role', 'access'],
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
        updateRoles(){
            const id = JSON.parse(this.role).id
            axios.put(`/api/roles/${id}/update`, {
                "name": this.name,
                "descriptions": this.descriptions,
                "permissions": this.permissions
            },{
                headers: {
                    'Content-Type': 'application/json'
                }
            }
            ).then(res => {
                if (res.data.success){
                    this.$toastr.s("Peran Diupdate!", "Berhasil");
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
        },
        setField(){
            this.name = JSON.parse(this.role).name
            this.descriptions = JSON.parse(this.role).descriptions
            this.permissions = this.access
        }
    },
    mounted(){
        this.setField()
    }
}
</script>

<style scoped>

</style>
