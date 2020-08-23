<?php
/**
 * Created by IntelliJ IDEA.
 * User: sridhar
 * Date: 22/8/20
 * Time: 10:42 PM
 */
?>
<form method="POST" >
    @csrf
    <div class="form-group">
        <label>Name*</label>
        <input type="text" placeholder="Name" class="form-control" :disabled='adminMode' v-bind:class="{ 'is-invalid' : errors.name }" v-model="form.name">
        <div class="invalid-feedback" v-if="errors.name">
            @{{ errors.name['0'] }}
        </div>
    </div>
    <div class="form-group">
        <label>Email Address*</label>
        <input type="email"  placeholder="Email"  class="form-control" :disabled='adminMode' v-bind:class="{ 'is-invalid' : errors.email }" v-model="form.email">
        <div class="invalid-feedback" v-if="errors.email">
            @{{ errors.email['0'] }}
        </div>
    </div>
    <div class="row form-group">
        <div class="col col-md-12">
            <label>Phone Number*</label>
            <div class="input-group">
                <div class="input-group-btn"><button class="btn btn-primary">+91</button></div>
                <input type="text"  placeholder="Phone Number"  class="form-control h-auto" :disabled='adminMode' v-bind:class="{ 'is-invalid' : errors.phone_number }" v-model="form.phone_number">
                <div class="invalid-feedback" v-if="errors.phone_number">
                    @{{ errors.phone_number['0'] }}
                </div>
            </div>

        </div>
    </div>


    <div v-if="!adminMode">
        <div class="form-group">
            <label>Password*</label>
            <input type="password" placeholder="Password"  class="form-control" v-bind:class="{ 'is-invalid' : errors.password }" v-model="form.password">
            <div class="invalid-feedback" v-if="errors.password">
                @{{ errors.password['0'] }}
            </div>
        </div>
        <div class="form-group">
            <label>Confirm Password*</label>
            <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control"  v-model="form.password_confirmation">
        </div>
        <button type="button" class="btn btn-primary btn-block m-b-30 m-t-30" @click="submit">Register</button>
        <div class="register-link m-t-15 text-center">
            <p>Already have account ? <a href="{{ route('login') }}"> Sign in</a></p>
        </div>
    </div>
    <div v-else>
        <div class="form-group">
            <label>Razorpay Id*</label>
            <input type="text" placeholder="Razorpay id"  class="form-control" v-bind:class="{ 'is-invalid' : errors.razorpay_id }" v-model="form.razorpay_id">
            <div class="invalid-feedback" v-if="errors.razorpay_id">
                @{{ errors.razorpay_id['0'] }}
            </div>
        </div>
        <div class="col-lg-12 ">
            <button type="button" class="btn btn-primary" @click="submit">Save</button>
            <button type="button" class="btn btn-secondary" @click="showGrid">Cancel</button>
        </div>
    </div>
</form>
