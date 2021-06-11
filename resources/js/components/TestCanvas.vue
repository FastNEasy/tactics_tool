/* eslint-disable no-unused-vars */
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
        <div class="buttonDiv">
            <div class="Buttons">
                <button class="button" @click="addHomePlayer(); coun=1">Add HOME player!</button>
                <button class="button" @click="removeHomePlayer(); coun=1">Remove HOME player!</button>
            </div>
            <div class="Buttons">
                <button class="button" @click="addAwayPlayer(); coun=2">Add AWAY player!</button>
                <button class="button" @click="removeAwayPlayer(); coun=2">Remove AWAY player!</button>
            </div>
            <!-- <div id="TestCanvas">
                <button v-on:click="addHome(); coun=1;">Addd 1</button>
                <p>The button above has been clicked {{ coun }} times.</p>
            </div> -->
        </div>
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
                    v-for="item in list"
                    ref="circle"
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
                        scaleX: dragItemId === item.id ? item.scale * 1.2 : item.scale,
                        scaleY: dragItemId === item.id ? item.scale * 1.2 : item.scale,
                        shadowColor: 'black',
                        shadowBlur: 10,
                        shadowOffsetX: dragItemId === item.id ? 15 : 5,
                        shadowOffsetY: dragItemId === item.id ? 15 : 5,
                        shadowOpacity: 0.6,
                        player: item.player,

                        prevCords: item.preCords,
                        dragBoundFunc: function (pos){
                            y1 =  pos.y < 10 ? 10 :pos.y && pos.y > 490 ? 490 :pos.y;
                            x1 = pos.x < 0 ? 10 :pos.x && pos.x >990 ? 990 :pos.x;
                            return{
                                x: x1,
                                y: y1,
                                
                            };
                        },
                    }"
                    
                ></v-circle>
                 <v-circle
                    v-for="item in awayList"
                    :key="item.id"
                    :config="{
                        x: item.x,
                        y: item.y,
                        rotation: item.rotation,
                        id: item.id,
                        radius: 20,
                        fill: '#89baa7',
                        opacity: 0.8,
                        draggable: true,
                        scaleX: awayDragItemId === item.id ? item.scale * 1.2 : item.scale,
                        scaleY: awayDragItemId === item.id ? item.scale * 1.2 : item.scale,
                        shadowColor: 'black',
                        shadowBlur: 10,
                        shadowOffsetX: awayDragItemId === item.id ? 15 : 5,
                        shadowOffsetY: awayDragItemId === item.id ? 15 : 5,
                        shadowOpacity: 0.6,
                        player: item.player,
                        dragBoundFunc: function (pos){
                            y1 =  pos.y < 10 ? 10 :pos.y && pos.y > 490 ? 490 :pos.y;
                            x1 = pos.x < 0 ? 10 :pos.x && pos.x >990 ? 990 :pos.x;
                            return{
                                x: x1,
                                y: y1,
                                
                            };
                        },
                    }"
                    
                ></v-circle>
               
            </v-layer>
        </v-stage>
        <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        <!-- <button @click="addPlayer">Add a player</button>
        <button @click="removePlayer">Remove a player</button>
        <button @click="lockCords">Lock in Cords!</button> -->
        <button @click="replayAnim">Replay animation</button>
    </div>
</template>

<script>
    // const width = window.innerWidth;
    // const height = window.innerHeight;
    import Konva from "konva";
    import SampleRequest from '@/api/sample-request';
    const sampleRequest = new SampleRequest();
    export default {
        
        name: 'TestCanvas',
        created() {
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
                id_preset: 56,
                canvas: null,
                context: null,
                img: null,
                drawIt: false,
                coords: [],
                //atskirigs
                // coords: [],
                list: [],
                awayList:[],
                player: null,
                dragItemId: null,
                awayDragItemId:null,
                delItemId: null,
                awayDelItemId:null,
                setItemCords: null,
                configKonva: {
                    width: 1000,
                    height: 500,
                    
                },
                count : 0,
                awayCount: 0,
                changeX : 175,
                awayChangeX: 600,
                iter: null,
                lock: [],
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
                const {data} = await sampleRequest.getSportsTypes({ id:this.id_preset});
                this.sportsName = data.sports_name;
                this.sports = data;
                this.image = data.field_picture;
                console.log('Data:', data.sports_name);
                this.img = new window.Image();
                this.img.src = this.image;
                this.img.onload = () => {
                    // set image only when it is loaded
                };
            },

            handleDragstart(e) {//starts to see which player is dragged and uses it respectivly
                // save drag element:
                console.log('player: ',this.coun);
                if(this.coun === 1){
                    // move current element to the top:
                    this.dragItemId = e.target.id();
                    console.log("atpazina home Player");
                    const item = this.list.find(i => i.id === this.dragItemId);
                    const index = this.list.indexOf(item);
                    // console.log(index);
                    this.list.splice(index, 1);
                    this.list.push(item);
                    this.shoutout("Drag started from ", item.x, item.y);
                }
                else{
                    console.log("Atpazina away Player");
                    this.dragItemId = e.target.id();
                    const item = this.awayList.find(i => i.id === this.dragItemId);
                    const index = this.list.indexOf(item);
                    this.list.splice(index,1);
                    this.list.push(item);
                    this.shoutout("Drag started from ", item.x, item.y);
                }
            },

            handleDragend(e) {//change the save coordinates of the player when the drag ends
                if(this.coun ===1){
                    this.dragItemId = e.target.id();//get the dragged player id
                    this.delItemId = this.dragItemId;
                    const item = this.list.find(i => i.id == this.dragItemId);
                 
                    // item.preCords.splice(1,1);
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemId = null;
                }
                else{
                    this.dragItemId = e.target.id();//get the dragged player id
                    this.delItemId = this.dragItemId;
                    const awayItem = this.awayList.find(i => i.id == this.dragItemId);
                    // item.preCords.splice(1,1);
                    this.shoutout("Old coordinates for: ",awayItem.id," is: ",awayItem.preCords);
                    this.shoutout("New coordinates for: ",awayItem.id," is: ",awayItem.x, awayItem.y);
                    this.dragItemId = null;
                }
            },

            addHomePlayer(e){//adds new player object at the top of the field
                if(this.count == 6){ return}
                this.changeX += 40;
                this.list.push({
                    id: this.count.toString(),
                    x: this.changeX,
                    y: 30,
                    preCords: [],
                    scale: 1
                });
                this.count++;
                this.shoutout("List data ",this.list);
            },

            removeHomePlayer(e){//removes last added player object
                var check = this.count-1;
                if(check <0){ return; }
                console.log("check: ",this.delItemId);
                const item = this.list.find(i => i.id === this.delItemId);
                this.shoutout("Item: ",item);
                const index = this.list.indexOf(item);
                this.shoutout("Deleted: ",index);
                this.list.splice(index, 1);
                this.count--;
                this.changeX-=40;
                if(this.count <= 0){
                    this.count = 0;
                }
                this.shoutout("List data ", this.list);
                this.delItemId = null;
            },

            addAwayPlayer(e){//adds new player object at the top of the field
                if(this.awayCount == 6){ return}
                this.awayChangeX += 40;
                this.awayList.push({
                    
                    id: this.awayCount.toString(),
                    x: this.awayChangeX,
                    y: 30,
                    preCords: [],
                    scale: 1
                });
                this.awayCount++;
                this.shoutout("Away List data ",this.awayList);
            },


            removeAwayPlayer(e){//removes last added player object
                var check = this.awayCount-1;
                if(check <0){ return; }
                console.log("check: ",this.awayDelItemId);
                const item = this.awayList.find(i => i.id === this.awayDelItemId);
                this.shoutout("Item: ",item);
                const index = this.awayList.indexOf(item);
                this.shoutout("Deleted: ",index);
                this.awayList.splice(index, 1);
                this.awayCount--;
                this.changeX-=40;
                if(this.awayCount <= 0){
                    this.awayCount = 0;
                }
                this.shoutout("Away List data ", this.awayList);
                this.delItemId = null;
            },
            
            lockCords(e){
                    //list.splice(start-1); nogrieziis visas koordinates iznemot pedejo
                    //ielikt listaa vecaas koordinates atbilstosham id, lai izveidotu pattern for animation
                    //just continue adding coords to the table
                    //pectam izveidojot animaciju, padot shos listus ,lai ar tiem darbotos
            },
            // addAwayPlayer(e){
            //     this.list.push({
            //         id: this.count.toString(),
            //         x: 600,
            //         y: 30,
            //         scale: 1
            //     });
            //     this.count++;
            //     this.shoutout("List data ",this.list);
                
            // },

            // removeAwayPlayer(e){
            //     const index = this.count-1;
            //     if(index <0){ return; }
            //     this.shoutout("Deleted: ",index);
            //     this.list.splice(index, 1);
            //     this.count--;
            //     if(this.count <= 0){
            //         this.count = 0;
            //     }
            // },


            // drawLine(x1, y1, x2, y2) {
            //     let ctx = this.context;
            //     ctx.beginPath();
            //     ctx.strokeStyle = 'black';
            //     ctx.lineWidth = 1;
            //     ctx.moveTo(x1, y1);
            //     ctx.lineTo(x2, y2);
            //     ctx.stroke();
            //     ctx.closePath();
            // },

            replayAnim(){
                const needed = this.list.find(i => i.id === this.delItemId);
                console.log(needed);
                let amplitute = 5;
                var velocity = 5;
                var anim = new Konva.Animation(function (frame) {
                    needed.x += (velocity * (50/ 1000))
                    needed.y +=   amplitute * Math.sin((frame.time * 2 * Math.PI) / 1000) 
                }, this.$refs.layer.getNode());
                anim.start();
            },
            // drawItem(index, x, y) {//draws the picture
            //     console.log('args:', index, x, y);
            //     this.img = new Image();
            //     this.img.src = this.image;
            //     console.log('this.image:', this.image);
            //     this.img.onload = () => {
            //         console.log('this.ctx:', this.context);
            //         this.context.drawImage(this.img, x, y);
            //     }
            // },
            // drawLine(x1, y1, x2, y2) {
            //     let ctx = this.context;
            //     ctx.beginPath();
            //     ctx.strokeStyle = 'black';
            //     ctx.lineWidth = 1;
            //     ctx.moveTo(x1, y1);
            //     ctx.lineTo(x2, y2);
            //     ctx.stroke();
            //     ctx.closePath();
            // },

            // getCoords(event){//translates coordinates for the canvas
            //     this.x1 = event.clientX;
            //     this.y1 = event.clientY;
            //     this.shoutout("Gotten x and y: ",this.x1,this.y1);
            //     var rect = event.target.getBoundingClientRect();
            //     this.shout(rect);
            //     this.translateCoords(rect, event.clientX, event.clientY);
            //     this.coords.push({ x: this.x1, y: this.y1 });
            //     this.counter++;
            //     if(this.counter == 2){
            //         this.drawLine(this.coords[0].x,this.coords[0].y, this.coords[1].x,this.coords[1].y);
            //         this.counter = 0;
            //         this.shout(this.coords);
            //         this.coords.splice(0);
            //     }
            // },
            // translateCoords(rect, x, y){
            //     var factor = 1080 / rect.width;
            //     this.shout(factor);
            //     this.x1 = factor * (x - rect.left);
            //     this.y1 = factor * (y - rect.top);
            //     this.shoutout("New x and y: ",this.x1,this.y1);
            // },

            // updateCoords(event){
            //     this.xpoint = event.clientX;
            //     this.ypoint = event.clientY;
            // },

            // testingCoords(){
            //     let stage = this.$refs.stage.getStage();
            //     var pos = stage.getPointerPosition();
            //     // console.log(pos);
            //     // var stageAttrs = stage.attrs;
            //     // console.log(stageAttrs);
            //     var x = pos.x;
            //     var y = pos.y;
            //     this.xpoint = x;
            //     this.ypoint = y;
            //     // console.log("Coords: ",x,y);
            // }
        },
    };
</script>

<style lang="scss" scoped>
    #canvasTest{
  

        // .stage{
        //     background-color:blue;
        // }
        .layer{
            background-color: rgb(23, 238, 23);
        }

        .stage{
            margin-left:5%;
            margin-top:1%;
        }

        .buttonDiv{
            display:table;
            margin-top:2%;
            margin-left:23%;
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
            font-family:'Roboto',sans-serif;
            font-weight:bold;
            color:#FFFFFF;
            background-color:#1db40f;
            text-align:center;
            transition: all 0.2s;
        }

        .button:hover{
            background-color: #f44336;
            color: white;
            cursor: pointer;
        }
    }

</style>