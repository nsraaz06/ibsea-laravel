Email Campaign Manager
An admin tool to design HTML email templates with a WYSIWYG editor and send them to targeted recipient groups (all members, specific members, form submitters, or custom emails).

Proposed Changes
Database Layer
[NEW] Migration: create_email_templates_table
Column	Type	Notes
id
bigint PK	
name	string	Internal template name
subject	string	Email subject line
body	longtext	Full HTML body (WYSIWYG output)
created_at/updated_at	timestamps	
[NEW] Migration: create_email_campaigns_table
Column	Type	Notes
id
bigint PK	
template_id	FK → email_templates	
subject	string	Subject at time of send (snapshot)
recipients	string	all_members, specific, form_submitters, custom
recipient_detail	text	JSON of specific IDs or custom emails
sent_count	int	How many emails actually sent
status	enum	pending, sent, failed
sent_at	timestamp	
Models & Mailable
[NEW] app/Models/EmailTemplate.php
Eloquent model for the template table
hasMany(EmailCampaign::class)
[NEW] app/Models/EmailCampaign.php
Eloquent model for campaigns/send log
[NEW] app/Mail/CampaignMail.php
Dynamic Mailable — accepts subject + HTML body + recipient name
Uses an inline Blade view with the passed HTML content
Supports {{name}}, {{email}}, {{member_id}} template variables
Admin Controller & Routes
[NEW] app/Http/Controllers/Admin/EmailTemplateController.php
Methods:

index()
 — list all templates
create()
 / 
store()
 — WYSIWYG template designer
edit()
 / 
update()
 — edit existing template
destroy()
 — delete template
send(Request, EmailTemplate) — show send form
dispatch(Request, EmailTemplate) — actually send, log campaign
Routes in 
web.php
 (admin group):
admin/email-templates              → index
admin/email-templates/create       → create
admin/email-templates/{id}/edit    → edit
admin/email-templates/{id}/send    → send form
admin/email-templates/{id}/dispatch→ POST dispatch
admin/email-campaigns              → campaign send history
Admin Views
[NEW] admin/email-templates/index.blade.php
Table of templates: name, subject, last sent, actions (Edit, Send, Delete)
"Create Template" button
[NEW] admin/email-templates/create.blade.php / 
edit.blade.php
TinyMCE WYSIWYG editor for the body (free CDN, no API key needed for basic)
Subject line input
Template name input
Live variable legend: {{name}}, {{email}}, {{member_id}}, {{date}}
[NEW] admin/email-templates/send.blade.php
Template preview panel
Recipient Group selector:
🔵 All Members
🟢 Specific Members (searchable multi-select)
🟡 Form Submitters (from a form — dropdown of forms)
🔴 Custom Emails (paste comma-separated list)
Send button with confirmation
[NEW] admin/email-campaigns/index.blade.php
History table: template, recipients, sent count, date, status
Sidebar Integration
[MODIFY] admin/partials/sidebar.blade.php
Add "Email Campaigns" dropdown with:

Templates
Send History
Email Rendering
[NEW] resources/views/emails/campaign.blade.php
Minimal wrapper that renders the raw HTML body from the template
Uses {!! $body !!} (safe — only admins can author templates)
Verification Plan
Manual Testing
Go to Admin → Email Campaigns → Create Template
Enter a subject, write HTML in the WYSIWYG editor using {{name}} variable
Save the template
Click Send on the template
Select "All Members" or enter a Custom Email (your own email)
Click Dispatch — verify email is received with name substituted correctly
Go to Send History — verify campaign row is recorded with correct sent count

Comment
Ctrl+Alt+M
What Got Built
Component	Details
DB Tables	email_templates + email_campaigns (send log)
WYSIWYG Designer	TinyMCE editor with full formatting, image, table, and code support
Variable Chips	Click {{name}}, {{email}}, {{member_id}}, {{date}} to insert at cursor
4 Recipient Types	All Members, Specific (multi-select), Form Submitters, Custom Emails
Send History	Logs every dispatch with sent/failed count and status
Sidebar	New "Email Campaigns" dropdown → Templates + Send History
How to Use
Admin Panel → Email Campaigns → Templates → New Template
Give it a name, write a subject (use {{name}} etc.)
Design the body using the WYSIWYG editor — full HTML, images, colors, tables
Click Save Template
Click Send on the template
Choose your recipient group and click Dispatch Campaign
Go to Send History to see the result
[!TIP] For the Health Day form — use recipient type "Form Submitters" and select the National Health Day form to email everyone who filled it. Their {{name}} will auto-substitute from the full_name field they submitted.