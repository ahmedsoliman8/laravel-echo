<template>
    <div class="row">
        <div class="col-md-8">

            <ul>
                <li v-for="task in project.tasks" :key="task.id" v-text="task.body"></li>
            </ul>

            <input type="text" v-model="newTask" @blur="save" @keydown="tapPeers">
            <span v-if="activePeer" v-text="activePeer.name+' is typing....'"></span>
        </div>

        <div class="col-md-4">
            <h4>Active Participants</h4>

            <ul>
                <li v-for="participant in participants" v-text="participant.name"></li>
            </ul>
        </div>

    </div>

</template>

<script>
    export default {
        props: ['data-project'],
        data(){
            return{
                items: [
                    { message: 'Foo' },
                    { message: 'Bar' }
                ],
               project:this.dataProject,
                newTask:'',
                activePeer:false,
                typingTimer:false,
                participants:[]
            };
        },
        mounted() {
         console.log(this.project.id);

        },
       created(){

            this.channel
                .here(users=>{
                    this.participants=users;
                })
                .joining(user=>{
                    this.participants.push(user);
                })
                .leaving(user=>{
                    this.participants.splice(this.participants.indexOf(user),1);
                })
                .listen("TaskCreated",({task})=>{
                this.addTask(task);
            }).listenForWhisper("typing",this.flashActivePeer);
        },
        computed:{
          channel(){
              return  window.Echo.join('tasks.'+this.project.id);
          }
        },
        methods:{
            flashActivePeer(e){
                    this.activePeer=e;
                    if(this.typingTimer) clearTimeout(this.typingTimer);
                    this.typingTimer= setTimeout(()=>{
                        this.activePeer=false;
                    },3000);

            },
            tapPeers(){
               this.channel.whisper("typing",{
                    name:window.App.user.name,

                });
            },
            save(){
                axios.post(`/api/projects/${this.project.id}/tasks`,{body:this.newTask})
                    .then(response=>response.data)
                    .then(this.addTask)  ;
            },
            addTask(task){
                this.project.tasks.push(task);
                this.newTask='';
                this.activePeer=false;
            }
        }
    }
</script>
