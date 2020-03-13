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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Participant $member
 * @property-read \App\Participant $participant
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant adult()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant family()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant infant()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant kids()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Dependant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant others()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Dependant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dependant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Dependant withoutTrashed()
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereUpdatedAt($value)
 */
	class Member extends \Eloquent {}
}

namespace App{
/**
 * App\Model
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model query()
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $deleted_by
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
 * @property-read \App\User $softDeletedBy
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Participant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereAttend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereAttendTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereAttendedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereIsVege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant wherePaymentBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant wherePaymentTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Participant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Participant withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Participant withoutTrashed()
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff whereStaffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff whereUpdatedAt($value)
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
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $active
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 */
	class User extends \Eloquent {}
}

