Retreat Booking Guru API
========================
This is the API definition for Booking Guru, and online software package
designed for retreat centers to manage bookings, retreats, rooms and
finances. The API allows access to programs, registrations and transactions
that are stored within the system to allow integration with custom software.
The same API is also used in our Zapier integration that allows connecting
Booking Guru to other applications without the need for custom code.


**Version:** 1.0.0

### /registrations
---
##### ***GET***
**Summary:** Registrations

**Description:** Registration details including names, emails and programs people have registered to.


**Parameters**

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| limit |  | Limit number of return values. The default limit is 20. Pass `limit=0` To get all the registrations without limits, but please use this with caution to not overload our servers.  | No | integer |

**Responses**

| Code | Description | Schema |
| ---- | ----------- | ------ |
| 200 | An array of registrations. | [ [Registration](#registration) ] |
| default | Error | [Error](#error) |

### Models
---

<a name="registration"></a>**Registration**  

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| id | integer |  | No |
| first_name | string |  | No |
| last_name | string |  | No |
| start_date | date |  | No |
| end_date | date |  | No |
| submitted | string (dateTime) |  | No |

<a name="error"></a>**Error**  

| Name | Type | Description | Required |
| ---- | ---- | ----------- | -------- |
| message | string |  | No |
