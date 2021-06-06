<template>
    <div class="pagination">
        <div class="wrapper">
            <span><</span>
            <span class="gape" v-if="gape_one">...</span>
            <span v-for="page in pagination_one" v-if="page" :class="(page.active?'active':'')" @click="pagePress(page.index)">{{page.index}}</span>
            <span class="gape" v-if="gape_two && is_paginate2">...</span>
            <span v-for="page in pagination_two" v-if="page && is_paginate2" :class="(page.active?'active':'')" @click="pagePress(page.index)">{{page.index}}</span>
            <span>></span>
        </div>
    </div>
</template>

<script>
    export default {
        name : 'Pagination',
        props:['total', 'per_page', 'last_index'],
        data(){
            return {
                is_paginate  : true,
                page_no      : '',
                pages        : [],
                total_page   : 0,
                is_paginate2 : true,
                active_page  : false,
                gape_one     : false,
                gape_two     : false,
                pagination_one    : [],
                pagination_two    : [],
            }
        },
        mounted(){
            if(!this.total && !this.per_page)
            this.is_paginate=false;
            this.pagination();
        },
        methods:{
            pagination:function(){
                if(this.is_paginate){
                    var total_page = this.total_page = Math.round(this.total/this.per_page);
                    for(var i = 1; total_page >= i; i++){
                        var start  = ((this.per_page*i)-this.per_page)+1;
                        var end    = (this.per_page*i);
                        this.pages.push({
                            index   : i,
                            start   : start,
                            end     : end,
                            active  : false,
                            gape    : false,
                        });
                    }
                    this.activePage();
                    this.deviding();
                    this.setPageNo();
                }
            },
            activePage:function(){
                var one = this.pages;
                for(const index in one){
                    if(one[index].start <= +this.last_index && +this.last_index <= one[index].end){
                        this.pages[index].active = true;
                    }
                }
            },
            deviding:function(){
                if(this.total_page <= 15){
                    this.pagination_one = this.pages;
                }
                else if(this.total_page > 15){
                    this.gape_two = true;
                    for(var i = 0; i<9; i++){
                        this.pagination_one.push(this.pages[i]);
                    }
                    this.stapTwoPosition();
                }
            },
            setPageNo:function(){
                if(this.total_page > 15){
                    var one = this.pages;
                    var atv_page = false;
                    one.map(x=>{if(x.active)atv_page=x.index;});
                    if(atv_page && atv_page > 8){
                        this.gape_one = true;
                        this.pagination_one = [];
                        for(var i=(atv_page-5); i<(atv_page+4); i++){
                            if(typeof this.pages[i] != 'undefined'){
                                this.pagination_one.push(this.pages[i]);
                            }
                        }
                    }else{
                        this.gape_one = false;
                        this.pagination_one = [];
                        for(var i=0; i<9; i++){
                            this.pagination_one.push(this.pages[i]);
                        }
                    }
                    this.stapTwoPosition();
                }
            },
            stapTwoPosition:function(){
                this.pagination_two = [];
                for(var i=5; i > 0; i--){
                    if((this.pagination_one).indexOf(this.pages[this.total_page - i]) > -1){
                        this.is_paginate2 = false;
                    }else{
                        this.is_paginate2 = true;
                        this.pagination_two.push(this.pages[this.total_page - i]);
                    }
                }
                if((this.pagination_one).length < 9){
                    var j = 10 - (this.pagination_one).length;
                    var start = +(this.pagination_one[0].index)-1;
                    for(var k = 1; k < j; k++){
                        this.pagination_one.unshift(this.pages[start-k]);
                    }
                }
            },
            pagePress:function(index){
                for(const key in this.pages){
                    if(this.pages[key].index == index){
                        this.pages[key].active = true;
                    }else{
                        this.pages[key].active = false;
                    }
                }
                this.setPageNo();
            }
        }
    }
</script>

<style scoped>
    .pagination{
        width: 100%;
        display: flex;
        padding: 5px;
        margin: 0;
    }
    .pagination .wrapper{
        display: flex;
    }
    .pagination span{
        padding: 1px 13px;
        margin-left: -1px;
        display: block;
        border: 1px solid #ddd;
        line-height: 24px;
        cursor: pointer;
        user-select: none;
        color: #616161;
    }
    .pagination span.active{
        color: red;
        border-radius: 0px 16px;
        position: relative;
        cursor: default;
    }
    .pagination span.active::after{
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        border: 1px solid #ddd;
        border-radius: 50%;
        z-index: 3;
    }
    .pagination span.gape{
        color: rgb(3 10 240);
        cursor: default;
    }
</style>