# Coding Standards Documents

## Jobs
All notifications or mailables that are called by listeners or jobs should NOT implement ShouldQueue


## Notifications
- Pass in $notifiable instead of $user to markdown
- End notification name in User or Admin
