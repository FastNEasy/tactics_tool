<template>
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
                <button class="button" @click="addHomePlayerTwo">Add HOME player!</button>
                <button class="button" @click="removeHomePlayerTwo">Remove HOME player!</button>
            </div>
            <div class="Buttons">
                <button class="button" @click="addAwayPlayer">Add AWAY player!</button>
                <button class="button" @click="removeAwayPlayer">Remove AWAY player!</button>
            </div>
        </div>
        <v-stage class="stage"
            ref="stage"
            :config="configKonva"
            @dragstart="handleDragstartTwo"
            @dragend="handleDragendTwo"
            @mousemove="testingCoords"

        >
            <v-layer ref="layer">
                <v-image :config="{
                    width: configKonva.width,
                    height: configKonva.height,
                    image: img,
                    listening: false,
                    fillEnabled: true,
                }"/>
                    <!-- <v-circle v-for="item in listHome" :key="item.id"></v-circle> -->
                <!-- <v-circle
                    v-for="item in listHome"
                    
                    :key="item.id"
                    :config="{
                        x: item.x,
                        y: item.y,
                        rotation: item.rotation,
                        id: item.id,
                        radius: 20,
                        fill: '#89b717',
                        opacity: 0.8,
                        draggable: true,
                        scaleX: dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                        scaleY: dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                        shadowColor: 'black',
                        shadowBlur: 10,
                        shadowOffsetX: dragItemHomeId === item.id ? 15 : 5,
                        shadowOffsetY: dragItemHomeId === item.id ? 15 : 5,
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
                    :ref="item.id"
                ></v-circle> -->
                <!-- <v-circle
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
                ></v-circle> -->
            </v-layer>
        </v-stage>
        <p>Coordinates: {{ xpoint }} / {{ ypoint }}</p>
        <!-- <button @click="addPlayer">Add a player</button>
        <button @click="removePlayer">Remove a player</button>
        <button @click="lockCords">Lock in Cords!</button> -->
        <button @click="replayAnim">Replay animation</button>
        <button @click="circleWork">Test!</button>
        <button @click="setCords">Lock coordinates!</button>
        <!-- <button @click="addPlayerHome">Add Player test2</button> -->
    </div>
</template>

<script>
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
                sportsName: null,
                image: null,
                xpoint: 0,
                ypoint: 0,
                x1: 0,
                y1: 0,
                counter: 0,
                id_preset: 23,
                canvas: null,
                context: null,
                img: null,
                drawIt: false,
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
                count3 : 0,
                changeHomeX : 175,
                changeHomeY : 30,
                changeAwayX: 950,
                iter: null,
                lock: [],
                setUp: 0,
                count2: 0,
                choiceId: null,
                isPlaying: 0,
                circle: null,
                cnt: 0,
                listHomePlayers: [],
                identy: null,
                tweensHome: [],
                count_times: 0,
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
                    item.preCords.push({x: this.x1, y:this.y1});
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
            handleDragstartTwo(e){//drag handler for inbuilt js circle creation
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.shoutout("The chosen one is: ", this.choiceId);
                    this.dragItemHomeId = e.target.id();
                    this.shoutout("dragItemHomeId", this.dragItemHomeId);
                    const item = this.listHome.find(i => i.id === this.dragItemHomeId);
                    const circle = this.listHomePlayers.find(i => i.id === this.dragItemHomeId);
                    const index = this.listHome.indexOf(item);
                    const index2 = this.listHomePlayers.indexOf(circle);
                    this.shoutout("Circle cord test: ", circle.circ.x());
                    this.x1 = item.x;
                    this.y1 = item.y;
                    this.shoutout(this.x1,this.y1);
                    // item.preCords.push({x: this.x1,y:this.y1});
                    this.listHome.splice(index, 1);
                    this.listHome.push(item);
                    this.listHomePlayers.splice(index2, 1);
                    this.listHomePlayers.push(circle);

                }else{
                    this.shoutout("-.0")
                }
            },
            handleDragendTwo(e){//drag end handler for inbuilt js circle creation
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.dragItemHomeId = e.target.id();
                    this.delItemHomeId = this.dragItemHomeId;
                    this.shoutout("delItemHomeId: ", this.delItemHomeId);
                    const item = this.listHome.find(i => i.id === this.dragItemHomeId);
                    const circle = this.listHomePlayers.find(i => i.id === this.dragItemHomeId);
                    // circle.circ.position({
                    //     x: e.target.x(),
                    //     y: e.target.y(),
                    // });
                    item.x = e.target.x();
                    item.y = e.target.y();
                    this.shoutout("Old coordinates for: ",item.id," is: ",item.preCords);
                    this.shoutout("New coordinates for: ",item.id," is: ",item.x,item.y);
                    this.dragItemHomeId = null;
                }else{
                    this.shoutout("-.0");
                }
            },
            setCords(e){//sets coordinates where you place them
                this.choiceId = this.delItemHomeId;
                if(this.choiceId.includes('Home_')){
                    this.shoutout("Cnt: ", this.cnt);
                    const item = this.listHome.find(i => i.id === this.delItemHomeId);
                    const player = this.listHomePlayers.find(i => i.id === this.delItemHomeId);
                    // this.tweensHome
                    item.preCords.push({ x:item.x,y:item.y});
                    this.shoutout("current coords added: ",item.preCords);
                    // const thisvar = {...player, x: 100};//very useful for maybe saving and using circles
                    
                    // player.circ.position({
                    //     x: item.preCords[this.cnt].x,
                    //     y: item.preCords[this.cnt].y,
                    // });
                    // item.x = item.preCords[0].x;
                    // item.y = item.preCords[0].y;
                    this.shoutout(player.circ);
                    // var tween = new Konva.Tween({
                    //     node: player.circ,
                    //     duration: 1,
                    //     x: item.preCords[this.cnt].x,
                    //     y: item.preCords[this.cnt].y,
                    //     onUpdate: () => console.log("props updated"),
                    //     onFinish: function(){
                    //         tween.pause();
                    //     }
                    // });
                    this.shoutout("X and Y of added: ", item.preCords[this.cnt].x, item.preCords[this.cnt].y);
                    // this.tweensHome.push(tween);
                    this.cnt++;
                    this.shoutout("Tweens: ", this.tweensHome);
                }    
            },
            handleDragend(e) {//change the save coordinates of the player when the drag ends
                this.choiceId = e.target.id();
                if(this.choiceId.includes('Home_')){
                    this.dragItemHomeId = e.target.id();//get the dragged player id
                    this.delItemHomeId = this.dragItemHomeId;
                    const item = this.listHome.find(i => i.id === this.dragItemHomeId);
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
            addHomePlayerTwo(e){//adds new player object and circle  to the stage
                this.shoutout("COUNT:", this.count);
                if(this.count == 6){ return; }
                this.changeHomeX += 40;
                this.identy = 'Home_'+this.rndStr(4);
                this.shoutout("I have created: ",this.identy, " with count: ",this.count);
                this.listHome.push({
                    id: this.identy,
                    x: this.changeHomeX,
                    y: this.changeHomeY,
                    preCords: [],
                    scale: 1
                });
                const item = this.listHome.find(i => i.id === this.identy);
                this.shoutout("Item: ", item);
                var circle = new Konva.Circle({
                    x: item.x,
                    y: item.y,
                    id: item.id,
                    radius: 20,
                    fill: '#89b717',
                    opacity: 0.8,
                    draggable: true,
                    scaleX: this.dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                    scaleY: this.dragItemHomeId === item.id ? item.scale * 1.2 : item.scale,
                    shadowColor: 'black',
                    shadowBlur: 10,
                    shadowOffsetX: this.dragItemHomeId === item.id ? 15 : 5,
                    shadowOffsetY: this.dragItemHomeId === item.id ? 15 : 5,
                    shadowOpacity: 0.6,
                    prevCords: item.preCords,
                    dragBoundFunc: function (pos){
                        this.y1 =  pos.y < 20 ? 20 :pos.y && pos.y > 480 ? 480 :pos.y;
                        this.x1 = pos.x < 20 ? 20 :pos.x && pos.x >980 ? 980 :pos.x;
                        return{
                            x: this.x1,
                            y: this.y1,
                        };
                    },
                });
                this.$refs.layer.getNode().add(circle);
                this.listHomePlayers.push({ id: this.identy,circ: circle });
                this.shoutout("Circle id: ", circle.id());
                this.shoutout("The circle list: ",this.listHomePlayers);
                this.count++;
                this.count3++;
                if(this.count3 == 6){ this.changeHomeY+=40; this.changeHomeX = 175; this.count3 = 0; }
                this.shoutout("COUNT: ", this.count);
            },
            removeHomePlayerTwo(e){//removes circle and 
                // var check = this.count-1;
                // if(check <0){ return; }
                if(this.delItemHomeId != null){
                    const item = this.listHome.find(i => i.id === this.delItemHomeId);
                    this.shoutout("Item: ",item);
                    const circle = this.listHomePlayers.find(i => i.id === this.delItemHomeId);
                    this.shoutout("Circle id that deletes: ", circle.circ.id());
                    this.shoutout("Item id that deletes: ", this.delItemHomeId);
                    const index = this.listHome.indexOf(item);
                    const index2 = this.listHomePlayers.indexOf(circle);
                    this.shoutout("Deleted circle: ", index2);
                    this.shoutout("Deleted item: ",index);
                    circle.circ.remove();
                    this.listHomePlayers.splice(index2, 1);
                    this.listHome.splice(index, 1);
                    this.count--;
                    // this.count3--;
                    this.shoutout("COUNT: ",this.count);
                    if(this.count <= 0){
                        this.count = 0;
                    }
                    this.shoutout("Home List data ", this.listHome);
                    this.shoutout("Home circle data ", this.listHomePlayers)
                    this.delItemHomeId = null;
                }else{
                    return;
                }
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
                let moveHome = this.listHome.find(i => i.id === this.delItemHomeId);
                let moveAway = this.listAway.find(i => i.id === this.delItemAwayId);
                var turnAroun1 = false;
                var turnAroun2 = false;
                this.shoutout(moveHome);
                this.shoutout(moveAway);
                let amplitude = 5;
                var velocity = 50;
                var anim = new Konva.Animation(function (frame) {
                    if(turnAroun1){
                        moveHome.x -= (velocity * (50/ 1000));
                        if(moveHome.x <= 20){
                            turnAroun1 = false;
                        }
                    }else if(moveHome.x >= 980){
                        turnAroun1 = true;
                    }else{
                        moveHome.x += (velocity * (50/ 1000));
                        moveHome.y += amplitude * Math.sin((frame.time * 2 * Math.PI) / 1000);
                    }
                    if(turnAroun2){
                        moveAway.x += (velocity * (50/ 1000));
                        if(moveAway.x >= 980){
                            turnAroun2 = false;
                        }
                    }else if(moveAway.x <= 20){
                        turnAroun2 = true;
                    }else{
                        moveAway.x -= (velocity * (50/1000));
                        moveAway.y += amplitude * Math.sin((frame.time * 2 * Math.PI)/1000);
                    }  
                }, this.$refs.layer.getNode());
                anim.start();
            },

            // replaySteps(){
            //     const player = this.list.find(i => i.id === this.delItemId);
            //     var boolcheck;
                // player.preCords.push({ x:player.x,y:player.y});
                // this.shoutout("current coords added: ",player.preCords);
            //     this.shoutout("how many in the list?",player.preCords.length);
                // player.x = player.preCords[1].x;
                // player.y = player.preCords[1].y;
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
            rndStr(len) {
                let text = "";
                let chars = "abcdefghijklmnopqrstuvwxyz";
                for( let i=0; i < len; i++ ) {
                    text += chars.charAt(Math.floor(Math.random() * chars.length));
                }
                return text;
            },
            circleWork(e){
                const item = this.listHome.find(i => i.id === this.delItemHomeId);
                const player = this.listHomePlayers.find(i => i.id === this.delItemHomeId);
                if(this.count_times == 0){
                    player.circ.position({
                    x: item.preCords[0].x,
                    y: item.preCords[0].y,
                });
                }
                // this.shoutout(this.tweensHome);
                // player.circ.position({
                //     x: item.preCords[0].x,
                //     y: item.preCords[0].y,
                // });
                // item.x = item.preCords[0].x;
                // item.y = item.preCords[0].y;
                //save start, end un node un pectam izsauks
                // for (const key in object) {
                //     if (Object.hasOwnProperty.call(object, key)) {
                //         const element = object[key];
                        //forin metode
                //     }
                // }
                // for (const iterator of object) {
                    //forof metode
                // }
                //TO DO: figure this shit out, how to make A become B and C become B, you can do this!
                //tween- between two. so A to B, to get to C, B needs to become A and C becomes B
                for(var i = 0; i< this.cnt;i++){
                    var tween = new Konva.Tween({
                        node: player.circ,
                        duration: 1,
                        x: item.preCords[i].x,
                        y: item.preCords[i].y,
                        onUpdate: () => console.log("props updated"),
                        onFinish: function(){
                            player.circ.position({
                                x: item.preCords[1].x,
                                y: item.preCords[1].y,
                            });
                            // tween.reset();
                            // tween.play();
                        }
                    });
                    tween.reset()
                    tween.play();
                }
                this.count_times++;
                // const player = this.listHome.find(i => i.id === this.delItemHomeId);
                // const circle = this.listHomePlayers.find(i => i.id === this.delItemHomeId);
                // // if(this.isPlaying == 0){
                // //     this.circle = new Konva.Circle({
                // //         x: player.preCords[1].x,
                // //         y: player.preCords[1].y,
                // //         rotation: player.rotation,
                // //         id: player.id,
                // //         radius: 15,
                // //         fill: 'white',
                // //         opacity: 0.8,
                // //         draggable: true,
                // //         scaleX: this.delItemHomeId === player.id ? player.scale * 1.2 : player.scale,
                // //         scaleY: this.delItemHomeId === player.id ? player.scale * 1.2 : player.scale,
                // //         shadowColor: 'black',
                // //         shadowBlur: 10,
                // //         shadowOffsetX: this.delItemHomeId === player.id ? 15 : 5,
                // //         shadowOffsetY: this.delItemHomeId === player.id ? 15 : 5,
                // //         shadowOpacity: 0.6,
                // //         prevCords: player.preCords,
                // //     });
                // //     this.$refs.layer.getNode().add(this.circle);
                // //     this.isPlaying++;
                // player.preCords.push({ x:player.x,y:player.y});
                // this.shoutout("current coords added: ",player.preCords);
                // circle.circ.position({
                //     x: player.preCords[1].x,
                //     y: player.preCords[1].y,
                // });
                // player.x = player.preCords[1].x;
                // player.y = player.preCords[1].y;
                // // }
                // this.shoutout(circle.circ);
                // var tween = new Konva.Tween({
                //     node: circle.circ,
                //     duration: 1,
                //     x: player.preCords[2].x,
                //     y: player.preCords[2].y,
                //     onUpdate: () => console.log("props updated"),
                //     onFinish: function(){
                //         tween.pause();
                //     }
                // });
                // tween.play();
                // this.circle.to({
                //     x: player.preCords[2].x,
                //     y: player.preCords[2].y,
                //     duration: 1,
                //     onUpdate: () => console.log("props updated"),
                //     onFinish: () => console.log("Finished!"),
                // });
                // var chec = this.$refs.layer.getNode().getChildren(function(node){
                //         return node.getClassName() === 'Circle';
                //     });
                // this.shoutout("the chosen circle: ",chec);
                // this.$refs.layer.getStage().to({
                //     x: player.preCords[2].x,
                //     y: player.preCords[2].y,
                //     duration: 1,
                //     onUpdate: () => console.log("props updated"),
                //     onFinish: () => console.log("Finished!"),
                // });
            },