
<template>
<!-- tatad, eror ir taja ka vienam ir list un otram list1, jaizdoma ka tur ielikt if, kurs pasaka kuru listu skatities(japadod kadam home vertiba).  
un erors ir taja, ka peivono klat un nonem un atkal vieno klat, tad duble id  -->
    <div id="canvasTest">
        <!-- <div>
            <canvas
                @mousemove="updateCoords" 
                @mousedown="getCoords"
                id="canv" class="canvas-test" width="1080" height="680" >
            </canvas>
            <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        </div>
        <div ref="draggableContainer" id="draggable-container">
            <div id="circle" class="circle" @mousedown="dragMouseDown"></div>    
        </div>
        <button v-on:click.once="drawItem(0, 0, 130)">Draw item 0</button> -->
         <div id="viewtactic">
                <h2>Tactic name is {{ tacticName }}</h2>
                <!-- <img :src="image"> -->
                <!-- <img id="imageHolder"> -->
        </div>
        <div class="buttonDiv">
            <div class="Buttons">
                <button class="button" @click="addHomePlayer(); coun=1">Add HOME player!</button>
                <button class="button" @click="removeHomePlayer(); coun=1">Remove HOME player!</button>
            </div>
            <div class="Buttons">
                <button class="button" @click="addAwayPlayer()">Add AWAY player!</button>
                <button class="button" @click="removeAwayPlayer()">Remove AWAY player!</button>
            </div>
            
            <!-- <div id="TestCanvas">
                <button v-on:click="addHome(); coun=1;">Addd 1</button>
                <p>The button above has been clicked {{ coun }} times.</p>
            </div> -->
        </div>
        <div class= "courtKonvas">
            <table class="Court" style="overflow-x:auto;" >
        <tr>
        <td>
        <v-stage class="stage"
            ref="stage"
            :config="configKonva"
            @dragstart="handleDragstart"
            @dragend="handleDragend"
        >
            <v-layer ref="layer">
                <v-image :config="{
                    width: configKonva.width,
                    height: configKonva.height,
                    image: img,
                    listening: false,
                    fillEnabled: true,
                }"/>
                <v-circle
                    v-for="item in listHome"
                    :key="item.id"
                    :config="{
                        x: item.x,
                        y: item.y,
                        rotation: item.rotation,
                        id: item.id,
                        radius: 20,
                        fill: '#89fbcf',
                        opacity: 0.8,
                        draggable: true,
                        scaleX: dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                        scaleY: dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                        shadowColor: 'black',
                        shadowBlur: 10,
                        shadowOffsetX: dragItemHomeId === item.id ? 15 : 5,
                        shadowOffsetY: dragItemHomeId === item.id ? 15 : 5,
                        shadowOpacity: 0.6,
                        player: item.player,

                        prevCords: item.preCords,
                        dragBoundFunc: function (pos){
                            y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                            x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                            return{
                                x: x1,
                                y: y1,
                            };
                        },
                    }"
                ></v-circle>
                <v-circle
                     v-for="item in listAway"
                    :key="item.id"
                    :config="{
                        x: item.x,
                        y: item.y,
                        rotation: item.rotation,
                        id: item.id,
                        radius: 20,
                        fill: 'red',
                        opacity: 0.8,
                        draggable: true,
                        scaleX: dragItemAwayId === item.id ? item.scale * 1.2 : item.scale,
                        scaleY: dragItemAwayId === item.id ? item.scale * 1.2 : item.scale,
                        shadowColor: 'black',
                        shadowBlur: 10,
                        shadowOffsetX: dragItemAwayId === item.id ? 15 : 5,
                        shadowOffsetY: dragItemAwayId === item.id ? 15 : 5,
                        shadowOpacity: 0.6,
                        prevCords: item.preCords,
                        dragBoundFunc: function (pos){
                            y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                            x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                            return{
                                x: x1,
                                y: y1,
                            };
                        },
                    }"
                    
                ></v-circle>
                 
               
            </v-layer>
        </v-stage>
        </td>
        </tr>
        
        </table>
        </div>
        <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        <!-- <button @click="addPlayer">Add a player</button>
        <button @click="removePlayer">Remove a player</button>
        <button @click="lockCords">Lock in Cords!</button> -->
        <button @click="replayAnim">Replay animation</button>
        <!-- <button @click="replaySteps">Play!</button> -->
        <!-- <button @click="addPlayerHome">Add Player test2</button> -->
    </div>
</template>


<script>
    import Konva from "konva";
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        name: 'TestCanvas',
        created(){
            this.getData();
        },
        data() {
            return {
                sports: {},
                coun: 0,
                sportsName: null,
                image: null,
                xpoint: 0,
                ypoint: 0,
                x1: 0,
                y1: 0,
                counter: 0,
                //id_preset: 69,
                canvas: null,
                context: null,
                img: null,
                drawIt: false,
                coords: [],

                tactics: {},
                id: this.$route.params.id,
                tacticName: null,
                presetID: null,
                ser : null,
                //image: null, //ir jau



                //atskirigs
                // coords: [],
                listHome: [],
                listAway: [],
                dragItemAwayId: null,
                dragItemHomeId: null,
                delItemHomeId: null,
                delItemAwayId: null,
                setItemCords: null,
                configKonva: {
                    width: 1000,
                    height: 500,
                    
                },
                count : 0,
                changeHomeX : 175,
                changeAwayX: 800,
                iter: null,
                lock: [],
                setUp: 0,
                count2: 0,
                choiceId: null,
                isPlaying: false,
            }
        },
        mounted(){//starts up with loading of the page
            // console.log("Izsaucas mounted");
            // this.canvas = document.getElementById("canv");
            // this.context = this.canvas.getContext('2d');
            // for (let n = 0; n < 5; n++) {
            //     this.list.push({
            //         id: Math.round(Math.random() * 10000).toString(),
            //         x: Math.random() * 1000,
            //         y: Math.random() * 500,
            //         rotation: Math.random() * 180,
            //         scale: 1
            //     });
            // }
        },
        methods: {
            async getData(){

                console.log("Editing:",this.id);
                const {data} = await sampleRequest.getTacticName({id:this.id});
                this.tactics = data;
                this.tacticName = data.tactic_name;
                console.log('Data:', data);
                this.presetID = data.id_presets;
                this.userID = data.id_user;
                this.image=data.sports_type.field_picture;
                
                //const {data} = await sampleRequest.getSportsTypes({ id:this.id_preset});
                //this.sportsName = data.sports_name;
                //this.sports = data;
                //this.image = data.field_picture;
                console.log('Data:', data.tactics_name);
                this.img = new window.Image();
                this.img.src = this.image;
                this.img.onload = () => {
                    // set image only when it is loaded
                };
            },
            handleDragstart(e) {//starts to see which player is dragged and uses it respectivly
                // save drag element:
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.shoutout("The chosen one is: ",this.choiceId);
                    this.dragItemHomeId = e.target.id();
                    // move current element to the top:
                    const item = this.listHome.find(i => i.id === this.dragItemHomeId);
                    const index = this.listHome.indexOf(item);
                    this.x1 = item.x;
                    this.y1 = item.y;
                    this.shoutout(this.x1,this.y1);
                    item.preCords.push({x: this.x1,y:this.y1});
                    // console.log(index);
                    this.listHome.splice(index, 1);
                    this.listHome.push(item);
                    this.shoutout("Drag started from ", item.x, item.y);
                } else{
                    this.dragItemAwayId = e.target.id();
                    const item = this.listAway.find(i => i.id === this.dragItemAwayId);
                    const index = this.listAway.indexOf(item);
                    this.x1 = item.x;
                    this.y1 = item.y;
                    this.shoutout(this.x1,this.y1);
                    item.preCords.push({x: this.x1, y: this.y1});
                    this.listAway.splice(index, 1);
                    this.listAway.push(item);
                    this.shoutout("Drag started: ", item.x, item.y);
                }
            },

            handleDragend(e) {//change the save coordinates of the player when the drag ends
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.dragItemHomeId = e.target.id();//get the dragged player id
                    this.delItemHomeId = this.dragItemHomeId;
                    const item = this.listHome.find(i => i.id == this.dragItemHomeId);
                    item.x = e.target.x();
                    item.y = e.target.y();
                    // item.preCords.splice(1,1);
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemHomeId = null;
                }else{
                    this.dragItemAwayId = e.target.id();
                    this.delItemAwayId = this.dragItemAwayId;
                    const item = this.listAway.find(i => i.id == this.dragItemAwayId);
                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemAwayId = null;
                }
                
            },

            addHomePlayer(e){//adds new player object at the top of the field
                if(this.count == 6){ return}
                this.changeHomeX += 40;
                this.listHome.push({
                    id: 'Home_'+this.count.toString(),
                    x: this.changeHomeX,
                    y: 30,
                    preCords: [],
                    scale: 1
                });
                this.count++;
                this.shoutout("List data ",this.listHome);
            },

            removeHomePlayer(e){//removes last added player object
                var check = this.count-1;
                if(check <0){ return; }
                console.log("check: ",this.delItemHomeId);
                const item = this.listHome.find(i => i.id === this.delItemHomeId);
                this.shoutout("Item: ",item);
                const index = this.listHome.indexOf(item);
                this.shoutout("Deleted: ",index);
                this.listHome.splice(index, 1);
                this.count--;
                this.changeHomeX-=40;
                if(this.count <= 0){
                    this.count = 0;
                }
                this.shoutout("Home List data ", this.listHome);
                this.delItemHomeId = null;
            },
                    //list.splice(start-1); nogrieziis visas koordinates iznemot pedejo
                    //ielikt listaa vecaas koordinates atbilstosham id, lai izveidotu pattern for animation
                    //just continue adding coords to the table
                    //pectam izveidojot animaciju, padot shos listus ,lai ar tiem darbotos

            addAwayPlayer(e){
                if(this.count2 == 6){ return; }
                this.changeAwayX -= 40;
                this.listAway.push({
                    id: 'Away_'+this.count2.toString(),
                    x: this.changeAwayX,
                    y: 30,
                    preCords: [],
                    scale: 1
                });
                this.count2++;
                this.shoutout("List data ",this.listAway);
            },

            removeAwayPlayer(e){
                var check = this.count2-1;
                if(check < 0){ return; }
                console.log("check: ", this.delItemAwayId);
                const item = this.listAway.find(i => i.id === this.delItemAwayId);
                this.shoutout("Item: ", item);
                const index = this.listAway.indexOf(item);
                this.shoutout("Deleted: ",index);
                this.listAway.splice(index, 1);
                this.count2--;
                this.changeAwayX+=40;
                if(this.count2 <= 0){
                    this.count2 = 0;
                }
                this.shoutout("Away List data: ", this.listAway);
                this.delItemAwayId = null;
            },
            replayAnim(){
                const moveHome = this.listHome.find(i => i.id === this.delItemHomeId);
                const moveAway = this.listAway.find(i => i.id === this.delItemAwayId);
                this.shoutout(moveHome);
                this.shoutout(moveAway);
                let amplitude = 5;
                var velocity = 5;
                var anim = new Konva.Animation(function (frame) {
                    if(moveHome.x == 980){ 
                        moveHome.y +=   amplitude * Math.sin((frame.time * 2 * Math.PI) / 1000)
                    }else{
                        moveHome.x += (velocity * (50/ 1000));
                        moveHome.y +=   amplitude * Math.sin((frame.time * 2 * Math.PI) / 1000)
                    }
                    if(moveAway.x == 20){
                        moveAway.y += amplitude * Math.sin((frame.time * 2 * Math.PI) /1000)
                    }else{
                        moveAway.x -= (velocity * (50/1000));
                        moveAway.y += amplitude * Math.sin((frame.time * 2 * Math.PI)/1000)
                    }  
                }, this.$refs.layer.getNode());
                anim.start();
            },
            // replaySteps(){
            //     const player = this.list.find(i => i.id === this.delItemId);
            //     var boolcheck;
            //     player.preCords.push({ x:player.x,y:player.y});
            //     this.shoutout("current coords added: ",player.preCords);
            //     this.shoutout("how many in the list?",player.preCords.length);
            //     player.x = player.preCords[1].x;
            //     player.y = player.preCords[1].y;
            //     var diffX = player.preCords[2].x - player.x;
            //     var diffY = player.preCords[2].y - player.y;
            //     //diffX/((frame.time * 2)/1000)
            //     // player.to(player.preCords[2].x,player.preCords[2].y);
            //     var anim = new Konva.Animation(function (frame){
            //         var xChange = diffX/(1000/1000);
            //         var yChange = diffY/(1000/1000);
            //         player.x += (xChange* (3/1000));
            //         player.y += (yChange* (3/1000));
                    
            //     },this.$refs.layer.getNode());
            //     anim.start();
            //     if(boolcheck == false){
            //          anim.stop();
            //     }
                // this.setUp++;
                // const plNode = this.$refs.layer.getNode();
                // plNode.to({
                //     x: player.preCords[2].x,
                //     y: player.preCords[2].y,
                //     duration: 0.5,
                //     onUpdate: () => console.log('props updated'),
                //     onFinish: () => console.log('finished'),
                // });
            // },
            updateCoords(event){
                this.xpoint = event.clientX;
                this.ypoint = event.clientY;
            },
            testingCoords(){
                let stage = this.$refs.stage.getStage();
                var pos = stage.getPointerPosition();
                var x = pos.x;
                var y = pos.y;
                this.xpoint = x;
                this.ypoint = y;
            },
            
            // fitStageIntoParentContainer() {
            //     var stage= new Konva.Stage({
            //         container: 'container',
            //         width: 1000,
            //         height: 500,
            //     })
            //     var container = document.querySelector('#stage-parent');

            //     // now we need to fit stage into parent
            //     var containerWidth = container.offsetWidth;
            //     // to do this we need to scale the stage
            //     var scale = containerWidth / 1000;

            //     stage.width(1000 * scale);
            //     stage.height(500 * scale);
            //     stage.scale({ x: scale, y: scale });
            // },
            // addPlayerHome(){
            //     if(this.count == 6){ return}
            //     this.changeX += 40;
            //     this.listHome.push({
            //         id: this.count.toString(),
            //         x: this.changeX,
            //         y: 30,
            //         preCords: [],
            //         identify: 'HOME',
            //         scale: 1
            //     });
            //     this.count++;
            //     var circle = new Konva.Circle({
            //         x: this.listHome.x,
            //         y: this.listHome.y,
            //         id: this.listHome.id,
            //         radius: 20,
            //         fill: '#89b717',
            //         opacity: 0.8,
            //         draggable: true,
            //         scaleX: this.dragItemHomeId === this.listHome.id ? this.listHome.scale * 1.2 : this.listHome.scale,
            //         scaleY: this.dragItemHomeId === this.listHome.id ? this.listHome.scale * 1.2 : this.listHome.scale,
            //         shadowColor: 'black',
            //         shadowBlur: 10,
            //         shadowOffsetX: this.dragItemHomeId === this.listHome.id ? 15 : 5,
            //         shadowOffsetY: this.dragItemHomeId === this.listHome.id ? 15 : 5,
            //         shadowOpacity: 0.6,
            //         prevCords: this.listHome.preCords,
            //         identifyBy: this.listHome.identify,
            //     });
            // },
        },
    };
</script>

<style lang="scss" scoped>
    #canvasTest{
        #viewtactic{
           //padding-left: 5%; 
           text-align: center;
        }
        //padding:10%;
        //margin: 0;

        // table, th, td {
        //     //border: 1px solid black;
        //     //border-collapse: collapse;
        //     // width: center;
        //     //  width: 50%;
        //     //  height: 2%
        // }
        table.Court {
            margin-left: auto; 
            margin-right: auto;
        }
        .courtKonvas{
            width: 100%;
        }
        // .stage{
        //     background-color:blue;
        // }
        .layer{
            background-color: rgb(23, 238, 23);
        }

        // .stage{
        //     // margin-left:1%;
        //     // margin-right:1%;
        //     // margin-top:1%;  
        //     // width: 100%;
        //     // // border: solid 1px blue; 
        //     // padding-right: 5%;
        //     // padding-left: 1%;
        //     // padding-top: 10px;
        //     // margin-left: auto;
        //     // margin-right: auto;
        //     // display: block;
        //     // width: center;
        //     //background-color: rgb(192, 192, 192);
            
             
        // }
        

        .buttonDiv{
            display:table;
            margin-top:2%;
            //margin-left: auto;
            margin:auto;
            text-align: center;
        }

        .Buttons{
            display:table-cell;
            width: 40%;
        }

        .button{
            margin-top:20%;
            display:inline-block;
            padding:0.3em 1.2em;
            margin:0 0.3em 0.3em 0;
            border-radius:2em;
            box-sizing: border-box;
            text-decoration:none;
            font-family:Arial;
            font-weight:bold;
            color:#FFFFFF;
            background-color:#1fc410;
            text-align:center;
            transition: all 0.2s;
        }

        .button:hover{
            background-color: rgb(25, 136, 30);
            color: white;
            cursor: pointer;
        }
    }

</style>