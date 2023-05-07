import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
from sklearn.linear_model import LinearRegression
from sklearn.model_selection import train_test_split
from datetime import datetime


# Load the data from the 'reserved-list' table
data = pd.read_csv('F:/Xampp/htdocs/parking/python/ML/reserved-list.csv')

# Convert the 'restime' column to datetime format
data['restime'] = pd.to_datetime(data['restime'])

# Remove missing, duplicate, or noisy data
data.drop_duplicates(inplace=True)
data.dropna(inplace=True)

# Add columns for the year, month, day of week and hour
data['year'] = data['restime'].dt.year
data['month'] = data['restime'].dt.month
data['dayofweek'] = data['restime'].dt.dayofweek
data['hour'] = data['restime'].dt.hour

# Group the data by year, month, day of week and hour and count the number of entries
traffic_data = data.groupby(['year', 'month', 'dayofweek', 'hour']).count()['id'].reset_index()

# Sum the traffic for each month
monthly_traffic = traffic_data.groupby(['year', 'month'])['id'].sum().reset_index().rename(columns={'id': 'traffic'})
monthly_traffic['year'] = monthly_traffic['year'].astype(int)
monthly_traffic['month'] = monthly_traffic['month'].astype(int)

# Print the monthly traffic
print(monthly_traffic)

# Get this month's traffic
current_year = datetime.now().year
current_month = datetime.now().month
current_dayofweek = datetime.now().weekday()
current_hour = datetime.now().hour
current_traffic = traffic_data.loc[(traffic_data['year'] < current_year) | ((traffic_data['year'] == current_year) & (traffic_data['month'] < current_month)), 'id'].sum()

while True:
    # Get input for the month and year to predict
    while True:
        try:
            max_month = 12 if current_year < monthly_traffic['year'].max() else monthly_traffic['month'].max()
            max_year = current_year if max_month != 12 else current_year + 1
            month = int(input(f"Enter the month to predict (as a number, after month {max_month}): "))
            year = int(input(f"Enter the year for the prediction (after {max_year}): "))
            if (year < current_year) or (year == current_year and month <= current_month) or (month > 12) or ((year, month) in zip(monthly_traffic['year'], monthly_traffic['month'])):
                raise ValueError
            break
        except ValueError:
            print(f"Please enter a valid future month and year (after {current_month}/{current_year}), or a month between {current_month+1} and 12 in {current_year+1} that is not in the CSV file.")

   # Prepare data for training
    if year == current_year and month <= current_month:
        training_data = traffic_data.copy()
    elif year <= current_year:
        # Weight the data based on their distance to the most recent data point
        dist = (current_year - traffic_data['year']) * 12 + (current_month - traffic_data['month'])
        weight = np.exp(-0.05 * dist)
        training_data = traffic_data.copy()
        training_data['weight'] = weight
        training_data = training_data[(training_data['year'] < year) | ((training_data['year'] == year) & (training_data['month'] < month))]
    else:
        training_data = traffic_data[(traffic_data['year'] < year) | ((traffic_data['year'] == year) & (traffic_data['month'] < month-1))]
        
    # Split the data into training and testing sets
    X_train, X_test, y_train, y_test = train_test_split(training_data[['year', 'month', 'dayofweek', 'hour']], training_data['id'], test_size=0.2)

   ## Train the linear regression model
    model = LinearRegression()
    model.fit(X_train, y_train)

    # Test the model
    score = model.score(X_test, y_test)
    #score = max(score, 0)
    print('R-squared:', score)
    
    # Predict traffic for the selected
    # Create a DataFrame with all the hours of the selected month
    hours = [i for i in range(24)]
    month_hours = pd.DataFrame({'year': [year]*24, 'month': [month]*24, 'dayofweek': [current_dayofweek]*24, 'hour': hours})
    
    # Make predictions for the selected month
    predicted_traffic = model.predict(month_hours)
   
    # Sum the predicted traffic for the month
    total_predicted_traffic = predicted_traffic.sum()
    
    # Print the predicted traffic
    predicted_traffic = max(total_predicted_traffic, 0)
    print(f"Predicted traffic for {month}/{year}: {total_predicted_traffic:.0f}")
   #================================
   
    #Create a DataFrame with the predicted traffic for each hour of the month
    predicted_traffic_df = pd.DataFrame({'hour': hours, 'traffic': predicted_traffic})

    #Create a DataFrame containing the monthly traffic for the given year
    monthly_traffic_df = pd.DataFrame({'month': monthly_traffic['month'], 'traffic': monthly_traffic['traffic']})

    #Create a line plot for the monthly traffic
    plt.plot(monthly_traffic_df['month'], monthly_traffic_df['traffic'], '-o', label='Monthly traffic')

    #Add data labels to the monthly traffic plot
    for i, value in enumerate(monthly_traffic_df['traffic']):
        plt.annotate(str(value), xy=(monthly_traffic_df['month'][i], value), xytext=(0, 5), textcoords='offset points', ha='center')

 
    # Add scatter points and text labels for predicted traffic for current and next two months
    plt.scatter(month, total_predicted_traffic, s=50, color='red')
    plt.annotate(f"{total_predicted_traffic:.0f}", xy=(month, total_predicted_traffic), xytext=(0, 5), textcoords='offset points', ha='center')
   
    #Set the plot title and axis labels
    plt.title(f"Monthly Traffic and Prediction in {month}/{year}")
    plt.xlabel('Month')
    plt.ylabel('Traffic')
    
    #Show the plot
    plt.show()
  