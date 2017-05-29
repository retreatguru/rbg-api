Retreat Booking Guru API
========================
**Version:** 1.0.0

### /registrations
---
##### ***GET***
**Summary:** Registrations

**Description:** Registration details including names, emails and programs people have registered to.


**Parameters**

| Name | Located in | Description | Required | Schema |
| ---- | ---------- | ----------- | -------- | ---- |
| limit | query | Limit number of return values. | No | integer |

**Responses**

| Code | Description | Schema |
| ---- | ----------- | ------ |
| 200 | An array of registrations | [ [Registration](#registration) ] |
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