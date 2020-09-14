<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Dependant
 *
 * @property int $id
 * @property string $name
 * @property string|null $relationship
 * @property string|null $staff_id
 * @property string|null $age
 * @property int $participant_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Participant $member
 * @property-read \App\Participant $participant
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant adult()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant family()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant infant()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant kids()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant newQuery()
 * @method static \Illuminate\Database\Query\Builder|Dependant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant others()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dependant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Dependant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Dependant withoutTrashed()
 */
	class Dependant extends \Eloquent {}
}

namespace App{
/**
 * App\Member
 *
 * @property int $id
 * @property string $name
 * @property string $staff_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Member whereUpdatedAt($value)
 */
	class Member extends \Eloquent {}
}

namespace App{
/**
 * App\Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Model query()
 */
	class Model extends \Eloquent {}
}

namespace App{
/**
 * App\Participant
 *
 * @property int $id
 * @property string $name
 * @property string $staff_id
 * @property string $email
 * @property string|null $division
 * @property int $member
 * @property string $payment_status
 * @property string|null $payment_details
 * @property string|null $payment_timestamp
 * @property int|null $payment_by
 * @property \App\User $attend
 * @property string|null $attend_timestamp
 * @property int|null $attended_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_vege
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $adults
 * @property-read int|null $adults_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $adultsFamily
 * @property-read int|null $adults_family_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $dependants
 * @property-read int|null $dependants_count
 * @property-read mixed $meal_option
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $infants
 * @property-read int|null $infants_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $infantsFamily
 * @property-read int|null $infants_family_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $kids
 * @property-read int|null $kids_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $kidsFamily
 * @property-read int|null $kids_family_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $othersAdults
 * @property-read int|null $others_adults_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $othersInfants
 * @property-read int|null $others_infants_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dependant[] $othersKids
 * @property-read int|null $others_kids_count
 * @property-read \App\User $payment
 * @property-read \App\User|null $softDeletedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Participant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Participant newQuery()
 * @method static \Illuminate\Database\Query\Builder|Participant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Participant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereAttend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereAttendTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereAttendedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereIsVege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant wherePaymentBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant wherePaymentTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Participant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Participant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Participant withoutTrashed()
 */
	class Participant extends \Eloquent {}
}

namespace App{
/**
 * App\Staff
 *
 * @property int $id
 * @property string $name
 * @property string $staff_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Staff whereUpdatedAt($value)
 */
	class Staff extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

