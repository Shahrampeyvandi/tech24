@extends('layouts.home.master-home')
@section('title') تکوان | جست و جو @endsection

@section('css')
<style>

</style>
@endsection

@section('scripts')

@endsection

@section('content')
  
    <div class="container">
        <search-component inline-template>
            <div class="row">
                <div class="col-md-12">
                    <div class="search-wrap">
                        <input class="form-control" type="text" v-model="word">
                        <button @click="search" :disabled="btnClass.disabled" :class="[btnClass]" class="btn btn_orange">
                            جست و جو
                        </button>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul class="search-tabs">
                        <li><a @click.prevent="activeTab(1,'all')" href="#" :class="[tab.index == 1 ? 'active' : '']">همه</a></li>
                        <li><a @click.prevent="activeTab(2,'course')" href="#" :class="[tab.index == 2 ? 'active' : '']">دوره ها</a></li>
                        <li><a @click.prevent="activeTab(3,'podcast')" href="#" :class="[tab.index == 3 ? 'active' : '']">پادکست ها</a></li>
                        <li><a @click.prevent="activeTab(4,'webinar')" href="#" :class="[tab.index == 4 ? 'active' : '']">وبینار ها</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="search-content">
                       <div v-if="totalResults !== 0">
                       <div class="loading" v-if="loading">درحال دریافت اطلاعات ...</div>
                        <div class="search-item" v-for="post in data.data">
                            <h3><a :href="post.slug">@{{post.title}}</a></h3>
                            <p>
                               @{{post.short_description}}
                            </p>
                            <span class="search-item-type" v-if="post.post_type == 'course'">نوع محتوا : دوره </span>
                            <span class="search-item-type" v-if="post.post_type == 'webinar'">نوع محتوا : وبینار</span>
                            <span class="search-item-type" v-if="post.post_type == 'podcast'">نوع محتوا : پادکست</span>
                        </div>
                       </div>
                       <div v-else>
                            <h3 class="text-right">هیچ مطلبی پیدا نشد</h3>
                       </div>
                    </div>
                </div>
            <pagination :data="data" @pagination-change-page="search"></pagination>
            </div>
        </search-component>

       
       
    </div>
@endsection