@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="pull-left">
                        Billing Information
                    </div>

                    <!-- If On Single Plan Application -> Show Price On Billing Heading -->
                    <div class="pull-right">
			<span v-if="plans.length == 1">
				(@{{ selectedPlanPrice }} / @{{ selectedPlan.interval | capitalize }})
			</span>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <div class="panel-body">
                    <spark-error-alert :form="forms.card"></spark-error-alert>

                    <form class="form-horizontal" role="form">
                        <div class="form-group" :class="{'has-error': forms.card.errors.has('number')}">
                            <label for="number" class="col-md-4 control-label">Card Number</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="number" data-stripe="number" v-model="forms.card.number">

                    <span class="help-block" v-show="forms.card.errors.has('number')">
                        <strong>@{{ forms.card.errors.get('number') }}</strong>
                    </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="number" class="col-md-4 control-label">Security Code</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="cvc" data-stripe="cvc" v-model="forms.card.cvc">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Expiration</label>

                            <div class="col-md-3">
                                <input type="text" class="form-control" name="month" placeholder="MM" maxlength="2" data-stripe="exp-month" v-model="forms.card.month">
                            </div>

                            <div class="col-md-3">
                                <input type="text" class="form-control" name="year" placeholder="YYYY" maxlength="4" data-stripe="exp-year" v-model="forms.card.year">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="number" class="col-md-4 control-label">ZIP / Postal Code</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="zip" v-model="forms.card.zip">
                            </div>
                        </div>

                        <div class="form-group" :class="{'has-error': forms.registration.errors.has('terms')}">
                            <div class="col-sm-6 col-sm-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" v-model="forms.registration.terms">
                                        I Accept The <a href="/terms" target="_blank">Terms Of Service</a>

		                    <span class="help-block" v-show="forms.registration.errors.has('terms')">
		                        <strong>@{{ forms.registration.errors.get('terms') }}</strong>
		                    </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-6 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary" @click.prevent="register" :disabled="forms.registration.busy">
						<span v-if="forms.registration.busy">
							<i class="fa fa-btn fa-spinner fa-spin"></i> Registering
						</span>

						<span v-else>
							<i class="fa fa-btn fa-check-circle"></i>

							<span v-if="! selectedPlan || ! selectedPlan.trialDays">
								Register
							</span>

							<span v-else>
								Begin @{{ selectedPlan.trialDays }} Day Trial
							</span>
						</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
