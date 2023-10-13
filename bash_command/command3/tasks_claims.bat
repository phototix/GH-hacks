@echo off

REM Create task for 15th
schtasks /create /tn "ClaimReminder15" /tr "msg * /time:0 Create Claims in WorkFlow" /sc monthly /d 15 /st 09:00

REM Create task for 16th
schtasks /create /tn "ClaimReminder16" /tr "msg * /time:0 Create Claims in WorkFlow" /sc monthly /d 16 /st 09:00

REM Create task for 17th
schtasks /create /tn "ClaimReminder17" /tr "msg * /time:0 Create Claims in WorkFlow" /sc monthly /d 17 /st 09:00

REM Create task for 18th
schtasks /create /tn "ClaimReminder18" /tr "msg * /time:0 Create Claims in WorkFlow" /sc monthly /d 18 /st 09:00

echo Tasks created successfully!
pause
